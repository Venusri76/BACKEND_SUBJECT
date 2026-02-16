<?php
class Profile 
{
    public $name;
    public $email;
    public $phonenumber;
    function set_name($n){
        $this->name=$n;
    }
    protected function set_email($n)
    {
        $this->email=$n;
    }
    private function set_phonenumber($n)
    {
        $this->phonenumber=$n;
    }
}
$mango= new Profile();
$mango->set_name('venu sri');
$mango->set_email('vbillaku');
$mango->set_phonenumber('1233009');
echo("ok");
?>
