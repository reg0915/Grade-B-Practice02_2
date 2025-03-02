<?php

date_default_timezone_set('Asia/Taipei');
session_start();

class DB{


protected $dsn ="mysql:host=localhost;charset=utf8;dbname=db222";
protected $pdo;
protected $table;



public function __construct($table) {
    $this->table = $table;
    $this->pdo= new PDO($this->dsn,'root','');
}



public function all(...$arg)
{
    $sql=" SELECT * FROM $this->table";
    if(!empty($arg[0]) && is_array($arg[0])){
        $tmp=$this->a2s($arg[0]);
        $sql .=" where ".join(" && ",$tmp); 
    }else if(isset($arg[0]) && is_string($arg[0])){
        $sql .=$arg[0];
    }if(isset($arg[0]) && !empty($arg[q])){
        $sql .=$arg[1];
    }

return $this->fetch_all($sql);


}
public function find($array)
{

    $sql=" SELECT * FROM $this->table ";
    if(is_array($array)){
        $tmp=$this->a2s($array);
        $sql .=" where ".join(" && ",$tmp); 
    }else{
  $sql .=" where `id` = '$array' ";
    }

return $this->fetch_one($sql);




}
public function save($array)
{
    if(isset($array['id'])){
$id=$array['id'];
unset($array['id']);
$tmp=$this->a2s($array);
$sql =" UPDATE $this->table SET ".join(",",$tmp)." where `id` = '$id' ";
    }else{
$keys=join("`,`", array_keys($array));
$values=join("','",$array);
$sql=" INSERT INTO $this->table (`{$keys}`) values('{$values}')"; 


    }
    return $this->pdo->exec($sql);
}
public function del($array)
{

    $sql=" DELETE * FROM $this->table ";
    if(!empty($array) && is_array($array)){
        $tmp=$this->a2s($array);
        $sql .=" where ".join(" && ",$tmp); 
    }else{
  $sql .=" where `id` = '$array' ";
    }

return $this->pdo->exec($sql);


}
public function count(...$arg)
{
    $sql=" SELECT * FROM $this->table";
    if(!empty($arg[0]) && is_array($arg[0])){
        $tmp=$this->a2s($arg[0]);
        $sql .=" where ".join(" && ",$tmp); 
    }else if(isset($arg[0]) && is_string($arg[0])){
        $sql .=$arg[0];
    }if(!empty($arg[1])){
        $sql .=$arg[1];
    }

return $this->pdo->query($sql)->fetchColumn();
}
public function fetch_one($sql)
{
return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
}
public function fetch_all($sql)
{
    return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}
public function a2s($array)
{

$tmp=[];

foreach( $array as $key => $value){
    $tmp[]=" `$key`='$value' ";
}

return $tmp;


}








}


function q($sql)
{
    $dsn="mysql:host=localhost;charset=utf8;dbname=db222";
    $pdo= new PDO($dsn,'root','');
    return $pdo->query($sql)->fetch_All();

}
function qCol($sql)
{
    $dsn="mysql:host=localhost;charset=utf8;dbname=db222";
    $pdo= new PDO($dsn, 'root', '');
    return $pdo->query($sql)->fetchColumn();



}
function dd($array)
{
echo "<pre>";

echo print_r($array);

echo "</pre>";

} 
function to($url)
{
header("location:" . $url);
} 


$Total=new DB ('total');
$User=new DB ('users');

if(!isset($_SESSION['total'])){
$today=date("Y-m-d");
$total=$Total->count(['date'=>$today]);
if($total)
{
$total['total']++;
$Total->save($total);
}else{

    $Total->save(['date'=>$today,'total'=>1]);
}

$_SESSION['total']=1;




}