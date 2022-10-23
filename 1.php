<html>
 <head>
  <title>Первое задание</title>
 </head>
 <body>
 <form method="post">
     <p>a: <label>
             <input type="text" name="val1" />
         </label></p>
     <p>b: <label>
             <input type="text" name="val2" />
         </label></p>
     <p><input type="submit" /></p>
 </form>
 <?php

 if(isset($_POST["val1"]) and isset($_POST["val2"]))
 {
     $a = $_POST["val1"];
     $b = $_POST["val2"];
     try {
         $primenums = findSimple($a, $b);
         for($i=0;$i<count($primenums);$i++)
             echo "$primenums[$i] <tr />";
         echo "<br /><br /><strong>Далее будет использоваться полученный массив</strong><br /><br />";
         echo "min=".getMin($primenums)."<br /><br />";
         $trapezes=createTrapeze($primenums);
         $trapezes=squareTrapeze($trapezes);
         printTrapeze($trapezes);
     }
     catch (Exception $ex)
     {
         echo $ex->getMessage();
     }
     catch (TypeError $ex)
     {
         echo "Необходимо ввести числа";
     }

 }
 function ifSimple(int $num) : bool
 {
     for($i=2;$i<=$num/2;$i++)
         if($num%$i==0)
             return false;
     return true;
 }
 function findSimple(int $a,int $b) : array
 {
     if($a<=0 or $b<=0)
         throw new Exception("Аргументы должны быть положительными");
     if($a>$b)
         throw new Exception("Введите b больше а");
     $primenums=[];
     for($i=$a;$i<=$b;$i++)
         if(ifSimple($i))
             $primenums[]=$i;
     return $primenums;
 }

 function createTrapeze(array $a) : array
 {
     $trapezes=[];
     $i=0;
     while(count($a)-$i>=3)
     {
         $trapeze=['a'=>$a[$i],'b'=>$a[$i+1],'c'=>$a[$i+2]];
         $trapezes[]=$trapeze;
         $i+=3;
     }
     return $trapezes;
 }
 function squareTrapeze(array $a) : array
 {
     for($i=0;$i<count($a);$i++)
     {
         $a[$i]['s']=($a[$i]['a']+$a[$i]['b'])*$a[$i]['c']/2;
     }
     return $a;
 }
 function getSizeForLimit(array $a,int $b) : array
 {
     $greatest=[];
     $max=0;
     foreach($a as $trap)
     {
         if($trap['s']>$max and $trap['s']<=$b)
         {
             $greatest=[];
             $max=$trap['s'];
             $greatest[]=$max;
         }
         if($trap['s']=$max)
             $greatest[]=$max;
     }
     return $greatest;
 }
 function printTrapeze(array $a)
 {
     echo "Таблица размеров и площади <br /><br />";
     for($i=0;$i<count($a);$i++) {
         foreach ($a[$i] as $key=>$elem)
             if($key=='s' and $elem%2==1)
               echo "<strong>$key=$elem</strong> <tr />";
             else
                 echo "$key=$elem <tr />";
         echo  "<br /><br />";
     }
     #echo count($a);
 }
 function getMin(array $a)
 {
     $min=$a[rand(0,count($a)-1)];
     foreach($a as $item)
     {
        if($item<$min)
            $min=$item;
     }
     return $min;
 }

 ?>
 <form method="post">
     <p>a: <label>
             <input type="text" name="val_1" />
         </label></p>
     <p>b: <label>
             <input type="text" name="val_2" />
         </label></p>
     <p>c: <label>
             <input type="text" name="val_3" />
         </label></p>
     <p><input type="submit" /></p>
 </form>

 <?php
 if(isset($_POST["val_1"]) and isset($_POST["val_2"]) and isset($_POST["val_3"]))
 {
     $a = $_POST["val_1"];
     $b = $_POST["val_2"];
     $c = $_POST["val_3"];
     $newclass=new F1($a,$b,$c);
     $res=$newclass->getValue();
     echo "<strong>$res</strong>";
 }
 abstract class BaseMath
 {
     function exp1(float $a,float $b,float $c) : float
     {
         return $a*($b**$c);
     }
     function exp2(float $a,float $b,float $c) : float
     {
         try
         {
             return ($a/$b)**$c;
         }
         catch(DivisionByZeroError $ex)
         {
             echo "Произошло деление на 0<br />";
         }
         return 0.0;
     }
     abstract function getValue() : float;
 }
 class F1 extends BaseMath
 {
     private $a,$b,$c;
     function __construct(float $a,float $b,float $c)
     {
         $this->a=$a;
         $this->b=$b;
         $this->c=$c;
     }
     function getValue() : float
     {
         return $this->exp1($this->a,$this->b,$this->c)+(($this->exp2($this->a,$this->b,$this->c))%3)**min($this->a,$this->b,$this->c);
     }
 }
 ?>
 </body>
</html>