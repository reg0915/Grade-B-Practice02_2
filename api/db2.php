<?php

session_start();

class DB {
protected $dsn="mysql:host=localhost;charset=utf8;dbname=db22";
protected $pdo;
protected $table;    

// public static $type={


// }

function __construct($table){
    $this->table=$table;
    $this->pdo=new PDO($this->dsn,'root','');
}



function all(...$arg){
$sql="SELECT * FROM $this->table ";
if(!empty($arg[0]) && is_array($arg[0])){
$tmp=$this->arrayToSQL($arg[0]);
$sql .=" where ".join(" && ",$tmp);
}else if(isset($arg[0]) && is_string($arg[0])){
$sql .=$arg[0];
}
if(isset($arg[0]) && ! empty($arg[1])){
    $sql .=$arg[1];
}

return $this->fetch_all($sql);
}



public function find($array){
    $sql="SELECT * FROM $this->table ";
if(is_array($array)){
$tmp=$this->arrayToSQL($array);
$sql .=" where ".join(" && ",$tmp);
}else{
    $sql .=" where `id`='$array'";

}
return $this->fetch_one($sql);
}


// public function save($array){
// if(isset($array['id'])){
//     $id=$array['id'];
//     unset($array['id']);
// $tmp=$this->a2s($array);
// $sql="update $this->table set" . join(",",$tmp) . "where `id`='$id'";


// }else{

// $keys = join("`,`",array_keys(($array)));
// $values=join("','",$array);
// $sql ="INSERT INTO  $this->table(`{$keys}`)  values('{$values}')";


// }

//     return $this->pdo->exec($sql);
// }


function save($array){
    // id: update table set
    if(isset($array['id'])){
        $id=$array['id'];
        unset($array['id']);
        $where = $this->a2s($array);
        $sql = "UPDATE $this->table set".join(',',$where)." where `id`='$id' ";
    }else{
        // !id: insert into table(`".join("`,`",)."`) values('".join("','",)."')
        $keys = array_keys($array);
        $sql = " INSERT INTO $this->table(`".join("`,`",$keys)."`) values('".join("','",$array)."')";
    }
    return $this->pdo->exec($sql);
}



public function del($array){
    $sql="DELETE FROM $this->table ";
    if(is_array($array)){
    $tmp=$this->arrayToSQL($array);
    $sql .=" where ".join(" && ",$tmp);
    }else{
        $sql .=" where `id`='$array'";
    
    }
    return $this->pdo->exec($sql);
    }



public function count(...$arg){
    $sql="SELECT * FROM $this->table ";
if(!empty($arg[0]) && is_array($arg[0])){
$tmp=$this->arrayToSQL($arg[0]);
$sql .=" where ".join(" && ",$tmp);
}else if(isset($arg[0]) && is_string($arg[0])){
$sql .=$arg[0];
}
if(empty($arg[1])){
    $sql .=$arg[1];
}

return $this->pdo->query($sql)->fetchColumn();
}













public function arrayToSQL($array){

$tmp=[];
foreach($array as $key =>$value){
    $tmp[]="`$key`='$value'";
}
return $tmp;
}
public function fetch_one($sql){
    return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
}
public function fetch_all($sql){
    return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}


}











// db外
function to($url){
header("location:".$url);

}




function dd($array){
echo "<pre>";
print_r($array);
echo "</pre>";
}





function q($sql){
   $dsn="mysql:host=localhost;charset=utf8;dbname=db22";
   $pdo=new PDO($dsn,'root','');
   return $pdo->query($sql)->fetchAll();
}