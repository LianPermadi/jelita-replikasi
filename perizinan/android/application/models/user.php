<?php
Class User extends CI_Model
{
 function login($username, $password)
 {
   $this -> db -> select('id, c_user, c_password');
   $this -> db -> from('truser');
   $this -> db -> where('c_user', $username);
   $this -> db -> where('c_password', MD5($password));
   $this -> db -> limit(1);

   $query = $this -> db -> get();

   if($query -> num_rows() == 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
}
?>