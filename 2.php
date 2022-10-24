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
    </body>
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
</html>