<html>
    <head>
        <title>Второе задание</title>
    </head>
    <body>
        <form method="post">
            <p>Введите текст: <label>
              <input type="text" name="val" />
                  </label></p>
            
            <p>Введите паттерн: <label>
              <input type="text" name="val2" />
                  </label></p>
            <p><input type="submit" /></p>
        </form>
    
<?php


if(isset($_POST["val"]) and $_POST["val2"])
    echo ConvertString($_POST["val"],$_POST["val2"]);
    #echo var_export(KnuthMorrisPrattSearch($_POST["val"],"abc"));


function ConvertString(string $text, string $pattern)
{
    $str=$text;
    $substrs= KnuthMorrisPrattSearch($text, $pattern);
    if(count($substrs)>=3)
    {
        $inverted = strrev($pattern);
        $str= substr_replace($str, $inverted, $substrs[1],strlen($inverted));
        #for($i=0;$i<strlen($inverted);$i++)
        #{
        #    $str[$i+$substrs[1]]=$inverted[$i];
        #}
    }
    return $str;
}
#Алгоритм поиска подстроки
function KnuthMorrisPrattSearch(string $text, string $pattern) : array
{
    $res=array();
    $n=strlen($text);
    $m=strlen($pattern);
    $i=$j=0;
    $pf= PrefixFunction($pattern.'#'.$text);
    for($i=0;$i<$n;$i++)
    {
        if($pf[$m+1+$i]==$m)
            $res[]=$i-$m+1;
    }
    return $res;
}
#Префикс-функция (см. алгоритм Кнутта-Мориса-Пратта)
function PrefixFunction(string $str) : array
{
    $p=array();
    $p[]=0;
    $k;
    for($i=1;$i<strlen($str);$i++)
    {
        $k=$p[$i-1];
        while($k>0 and $str[$i]!=$str[$k])
            $k=$p[$k-1];
        if($str[$i]==$str[$k])
            ++$k;
        $p[]=$k;
            
    }
    return $p;
}
?>
        <form method="post">
            <p>Введите ключ по которому будет отсортирован массив: <label>
              <input type="text" name="key" />
                  </label></p>
            <p><input type="submit" /></p>
        </form>
<?php

if(isset($_POST["key"]))
{
    $matrix = array();
    
    for($i=0; $i<10; $i++)
    {    
        $row=array();
        for($j='a'; $j<'f'; $j++)
        {
            $row[$j]=rand(0,100);
        }
        $matrix[] = $row;
    }
    print_r($matrix);


echo "Массив сгенерирован случайным образом<br /><br /><br /><br />";
    try{
    mySortForKey($matrix, $_POST["key"]);
    print_r($matrix);
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
    }
}
#Используется сортировка алгоритмом Шелла
function mySortForKey(array &$a, mixed $b)
{
    $sort_length = count($a) - 1;
	$step = intval(ceil(($sort_length + 1)/2));

	do{
		$i = ceil($step);
	   do
	   {
	     $j=$i-$step;
	     $c=1.0;
             if (!isset($a[$j][$b]))
                 throw new Exception ("Данного ключа не существует в массиве под номером ". $j);
             do
	     { 
                   if($a[$j][$b]<=$a[$j+$step][$b])
	            {
		  	$c=0.0;
	            }
	       else
		   {
		      $tmp=$a[$j];
		      $a[$j]=$a[$j+$step];
		      $a[$j+$step]=$tmp;
		   }
		$j=$j-1;
               
	     }
	     while($j>=0 && ($c==1));
	      $i = $i+1;
	    }
	    while($i<=$sort_length);

		// конец цикла
		$step = intval($step / 2);
	}
	while($step > 0);
}
?>
        
<?php
//exportXML('exemel.xml', 1);
importXML('a');


function exportXML(string $a,int $b)
{
// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$database_name = "test_samson";

try{
    $dbh=new PDO("mysql:host=$host;dbname=$database_name", $username, $password);
    $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
    //$q1=$dbh->exec('SELECT * FROM a_product');
    $q1 = $dbh->prepare('SELECT * FROM a_product INNER JOIN product_category ON a_product.Id=product_category.Id_prod AND product_category.Id_category=?;');  
    $q1->execute([$b]);
  
$q1->setFetchMode(PDO::FETCH_ASSOC);  

$doc = new DOMDocument('1.0', 'UTF-8');
$products = $doc->createElement('Products');
  
foreach($q1 as $row) 
   {  
//    echo $row['Name'];
//    echo $row['Code'];
    
    $product=$doc->createElement('Product');
    $product->setAttribute('Name', $row['Name']);
    $product->setAttribute('Code', $row['Code']);
    $q2 = $dbh->prepare('SELECT Type,Price FROM a_price INNER JOIN a_product ON a_product.Id=a_price.Id_prod AND a_product.Id=?;');  
    $q2->execute([$row['Id']]);
    $q2->setFetchMode(PDO::FETCH_ASSOC);  
    foreach ($q2 as $row2)
    {
        $price=$doc->createElement('Price',$row2['Price']);
        $price->setAttribute('Type', $row2['Type']);
        $product->appendChild($price);
    }
    $props=$doc->createElement('Properties');
    $q2 = $dbh->prepare('SELECT Property,Value FROM a_property INNER JOIN a_product ON a_product.Id=a_property.Id_prod AND a_product.Id=?;');  
    $q2->execute([$row['Id']]);
    foreach ($q2 as $row2)
    {
        $prop=$doc->createElement($row2['Property'],$row2['Value']);
        $props->appendChild($prop);
    }
    $product->appendChild($props);
    
    $q2 = $dbh->prepare('SELECT * FROM a_category INNER JOIN product_category ON a_category.Id=product_category.Id_category AND product_category.Id_prod=?;');  
    $q2->execute([$row['Id']]);
    $q2->setFetchMode(PDO::FETCH_ASSOC);  
    $cats=$doc->createElement('Categories');
    foreach ($q2 as $row2)
    {
        $cat=$doc->createElement('Category',$row2['Name']);
        $cats->appendChild($cat);
    }
    $product->appendChild($cats);
    
    $products->appendChild($product);
    
    
    }
$doc->appendChild($products);

// Set the appropriate content-type header and output the XML
//header('Content-type: application/xml');
//var_dump($doc->saveXML());
$doc->save($a);

echo 'Success export';
    
} catch (PDOException $ex) {
  echo $ex->getMessage();
}
}

function importXML(string $a)
{
    // Database configuration
$host = "localhost";
$username = "root";
$password = "";
$database_name = "test_samson";

try
{
    $dbh=new PDO("mysql:host=$host;dbname=$database_name", $username, $password);
    $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
    $xml=simplexml_load_file($a);
//    echo $xml->Product[0]->Categories->Category[0]. "<br>";
//    echo $xml->Product[0]->Properties->children(). "<br>";
//    var_dump($xml);
    for($i=0;$i<count($xml->Product);$i++)
    {
        $p_name=$xml->Product[$i]->attributes()[0];
        $p_code=$xml->Product[$i]->attributes()[1];
        $query=$dbh->prepare("INSERT INTO a_product (Code,Name) VALUES (?,?)");
        $query->execute([$p_code,$p_name]);
        for($j=0;$j<count($xml->Product[$i]->Price);$j++)
        {
            $pr_type=$xml->Product[$i]->Price[$j]->attributes();
            $pr_val=$xml->Product[$i]->Price[$j];
            $query=$dbh->prepare("INSERT INTO a_price (Type,Price) VALUES (?,?)");
            $query->execute([$pr_type,$pr_val]);
        }
        foreach($xml->Product[$i]->Properties->children() as $k=>$v)
        {
            $prop=$k;
            $val=$v;
            $query=$dbh->prepare("INSERT INTO a_property (Property,Value) VALUES (?,?)");
            $query->execute([$prop,$val]);
        }
        for($j=0;$j<count($xml->Product[$i]->Categories->Category);$j++)
        {
            $query=$dbh->prepare("INSERT INTO a_category (Name) VALUES (?)");
            $query->execute([$xml->Product[$i]->Categories->Category[$j]]);
        }
    }
    
    echo '  Success import';
} catch (PDOException $ex) {
  echo $ex->getMessage();
}
}
?>
        
     </body>
</html>