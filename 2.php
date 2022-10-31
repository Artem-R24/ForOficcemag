<html>
    <head>
        <title>Второе задание</title>
    </head>
    <body>
        <form method="post">
            <p>Введите текст: <label>
              <input type="text" name="val" />
                  </label></p>
            <p><input type="submit" /></p>
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


echo "<br /><br /><br /><br />";

if(isset($_POST["key"]))
{
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

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$database = 'test_samson';
$user = 'root';
$pass = 'rootpassword';
$host = 'localhost';
$dir = dirname(__FILE__) . '/dump.sql';

echo "<h3>Backing up database to `<code>{$dir}</code>`</h3>";

exec("mysqldump --user={$user} --password={$pass} --host={$host} {$database} --result-file={$dir} 2>&1", $output);

var_dump($output);
#exec('mysqldump --user=root --password= --host=localhost test_samson > /path/to/output/file.sql');
?>
        
     </body>
</html>