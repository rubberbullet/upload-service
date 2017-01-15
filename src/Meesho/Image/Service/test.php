<?php 
$redis=new Redis() or die("Can not load Redis.");
$redis->connect('172.17.0.3',6379); 
$redis->set('Redis test_key', 1);
