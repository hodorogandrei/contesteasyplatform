<? if(1): ?>
<p>test</p>
<? else: ?>         
<p>test2</p>
<? endif; ?>

<? for($i = 1; $i <= 100; $i++): ?>
<? endfor; ?>
<?
$email = 'ceva@ceva.com';
$email = 1;
try{
    if(!strlen(trim($email)))
        throw new Exception('Adresa este goala.');
    if(is_int($email))
        throw new Exception('Nu este voie cu int buhaiule !!!.');
    echo 99;
} catch(Exception $e){
    echo $e->getMessage();
}       
?>