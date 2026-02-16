<?php
// class for the custom exception
class customExcetion extends Exception
{
    public function errorMessage()
    {
        $errorMsg='Error on line'. $this->getLine().' in '.$this->getFile()
        .':<br>'.$this->getMessage().'</b> is not valid E-mail address';
        return $errorMsg;
    }
}
$email="vbillaku@aum.edu";
try{
    if(filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE)
    {
        // object of custom exception class
        throw new customExcetion($email);
    }else{
        echo("valid email");
    }
}catch (customExcetion $e)
{
    echo $e->errorMessage();
}
?>