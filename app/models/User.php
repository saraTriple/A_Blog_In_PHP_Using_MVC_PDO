<?php
    class User {
        private $db;

        public function __construct()
        {
            $this->db = new Database;
        }


        public function register($data)
        {
            $this->db->query("insert into users(user_name, user_email, password)
                                        values (:username , :email , :password)");

            // Bind values
            $this->db->bind(':username' , $data['username']);
            $this->db->bind(':email' , $data['email']);
            $this->db->bind(':password' , $data['password']);

            // Execute function
            if($this->db->execute()) {
                return true;
            }else {
                return false;
            }
        }

        public function login($username , $password)
        {
            $this->db->query('select * from users where user_name = :username');

            // Bind value
            $this->db->bind(':username' , $username);

            $user = $this->db->single();

            $hashed_password = $user->password;

            if(password_verify($password , $hashed_password)) {
                    return  $user;
            }else {
                return false;
            }
        }
        
        public function getUsers()
        {
           $this->db->query("select * from users");

           $result = $this->db->resultSet();

           return $result;

        }

        //Find user by email, email is passed in by the controller
        public function findUserByEmail($email)
        {
            // Prepared statement
            $this->db->query("select * from users where user_email = :email");

            // email param will be binded with the email variable
            $this->db->bind(':email' , $email);

            // Chwck if email is already registered
            if($this->db->rowCount() > 0) {
               return true;
            }else {
                return false;
            }
        }

        public function findUserByUsername($username)
        {
            // Prepared statement
            $this->db->query("select * from users where user_name = :username");

            // email param will be binded with the email variable
            $this->db->bind(':username' , $username);

            // Chwck if username is already registered
            if($this->db->rowCount() > 0) {
                return true;
            }else {
                return false;
            }
        }

    }