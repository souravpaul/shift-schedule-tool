<?php

class Mail extends Model{

   protected $Username;
   protected $Password;
   protected $Host;
   protected $WordWrap;


   function __construct(){
       parent::__construct();
       
        $this->Host = MAIL_HOST;
        $this->Username = MAIL_USER;
        $this->Password = MAIL_PASSWORD;
        $this->WordWrap = MAIL_WORD_WRAP;
        require("class.phpmailer.php");
    }

    public function sendMail($to, $sub, $body, $sender_email="",$sender_name="Shift Schedule")
    {
        if(empty($to) || empty($sub) || empty($body))
            return ERROR;

     /*   $domain = substr($to, (strpos($to, '@')+1));
        if (! (checkdnsrr($domain) !== FALSE))
            return ERROR;*/		

        $mail = new PHPMailer();
        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->SMTPDebug = 0;
        $mail->Host = $this->Host;

        $mail->Username = $this->Username;
        $mail->Password = $this->Password;
        $mail->From = $sender_email;
        $mail->FromName = $sender_name;
        $mail->AddAddress($to);
        $mail->Subject = $sub;
        $mail->MsgHTML($body);
        
        $mail->WordWrap = $this->WordWrap;

        $body=htmlentities($body);
        $body=mysql_real_escape_string($body);

        if(true)//!$mail->Send()
        {		
            $sql="INSERT INTO EMAIL_LOG (SENDER,SENDER_NAME,RECEIVER,SUBJECT,BODY) 
                VALUES ('$sender_email','$sender_name','$to','$sub','".$body."')";
        }
        else
        {
            $sql="INSERT INTO EMAIL_LOG (SENDER,SENDER_NAME, RECEIVER,SUBJECT,BODY,MAIL_STATUS) 
                VALUES ('$sender_email','$sender_name','$to','$sub','".$body."','SENT')";
        }
        
        if( $this->query($sql) ){
            $result=$this->getInsertId();            
        }else{
            //echo $this->getError();
        }
        
        return $result;
    }
}

?>
