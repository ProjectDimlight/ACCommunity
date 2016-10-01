<?php

class Socket
{
    public $sockets,
           $users,
           $master;

    private $sda = array(),
            $slen = array(),
            $sjen = array(),
            $ar = array(),
            $n = array();
    
    public function __construct($address, $port)
    {
        $this->master = $this->WebSocket($address, $port);
        $this->sockets = array($this->master);
    }

    public function main_loop()
    {
        while(true)
        {
            $changes = $this->sockets;
            $write = $except = NULL;
            socket_select($changes, $write, $except, NULL);

            foreach($change as $sock)
            {
                if($sock == $this->master)
                {
                    $client = socket_accept($this->master);
                    $this->sockets[] = $client;
                    $this->users[] = array('socket' => $client, 'shou' => false);
                }else
                {
                    $len = socket_recv($sock, $buffer, 2048, 0);
                    $k = $this->search($sock);
                    
                    if(!$this->users[$k]['hand'])
                    {
                        $this->shake_hand($k, $buffer);
                    }else
                    {
                        $buffer = $this->uncode($buffer);
                        $this->send($k, $buffer);
                    }
                }
            }
        }
    }

    public function close($sock)
    {
        $k = array_search($sock, $this->sockets);
        socket_close($sock);
        unset($this->sockets[$k]);
        unset($this->users[$k]);
    }

    function search($sock)
    {
        foreach($this->users as $k => $v)
            if($sock == $v['socket'])
                return $k;
        return false;
    }

    function start($address, $port)
    {
        $server = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_set_option($server, SOL_SOCKET, SO_REUSEADDR, 1);
        socket_bind($server, $address, $port);
        socket_listen($server);
        return $server;
    }

    function shake_hands($k, $buffer)
    {
        $buf  = substr($buffer, strpos($buffer, 'Sec-WebSocket-Key:') + 18);
        $key  = trim(substr($buf, 0, strpos($buf,"\r\n")));
     
        $new_key = base64_encode(sha1($key."258EAFA5-E914-47DA-95CA-C5AB0DC85B11", true));
         
        $new_message = "HTTP/1.1 101 Switching Protocols\r\n";
        $new_message .= "Upgrade: websocket\r\n";
        $new_message .= "Sec-WebSocket-Version: 13\r\n";
        $new_message .= "Connection: Upgrade\r\n";
        $new_message .= "Sec-WebSocket-Accept: " . $new_key . "\r\n\r\n";
         
        socket_write($this->users[$k]['socket'], $new_message, strlen($new_message));
        $this->users[$k]['hand'] = true;
        return true;
    }

    function code($msg)
    {
        $msg = preg_replace(array('/\r$/', '/\n$/', '/\r\n$/',), '', $msg);
        $frame = array();  
        $frame[0] = '81';  
        $len = strlen($msg);  
        $frame[1] = $len < 16 ? '0'.dechex($len) : dechex($len);  
        $frame[2] = $this->ord_hex($msg);  
        $data = implode('', $frame);  
        return pack("H*", $data);  
    }

    function decode($str)
    {
        $mask = array();  
        $data = '';  
        $msg = unpack('H*', $str);  
        $head = substr($msg[1], 0, 2);  
        if (hexdec($head{1}) === 8)  
            $data = false;  
        else if (hexdec($head{1}) === 1)
        {  
            $mask[] = hexdec(substr($msg[1],4,2));  
            $mask[] = hexdec(substr($msg[1],6,2));  
            $mask[] = hexdec(substr($msg[1],8,2));  
            $mask[] = hexdec(substr($msg[1],10,2));  
           
            $s = 12;  
            $e = strlen($msg[1])-2;  
            $n = 0;  
            for ($i = $s; $i <= $e; $i += 2)
            {  
                $data .= chr($mask[$n % 4] ^ hexdec(substr($msg[1], $i, 2)));  
                $n++;
            }  
        }  
        return $data;
    }

    function ord_hex($data)
    {  
        $msg = '';  
        $l = strlen($data);  
        for ($i = 0; $i < $l; $i++)  
            $msg .= dechex(ord($data{$i}));
        return $msg;  
    }

    
}

?>