<?php
class Fruit 
{
    public $name;
    public $color;
    public $weight;
    function set_name($n){
        $this->name=$n;
    }
    protected function set_color($n)
    {
        $this->color=$n;
    }
    private function set_weight($n)
    {
        $this->weight=$n;
    }
    function set_fruits($color, $weight)
    {
        $this->set_color($color);
        $this->set_weight($weight);
    }
}
class Mango extends Fruit
{
    public function details()
    {
        return "Fruit: $this->name, Color: $this->color,Weight: $this->weight";
    }
}
$mango= new Mango();
$mango->set_name('Mango');
$mango->set_fruits('Yellow','300');
echo $mango->details();
echo("Ok");
?>
