<?php

class Post
{
    private $db;

    public function __construct()
    {
       $this->db = new Database;
    }

    public function findAllPosts()
    {
       $this->db->query('select * from posts order by created_at desc ');

       $results = $this->db->resultSet();

       return $results;
    }

    public function createPost($data)
    {
        $this->db->query("insert into posts(user_id , title, body, created_at) values (:user_id ,:title , :body , :created_at)");

        $created_at = date("Y-m-d H:i:s");
        // Bind values
        $this->db->bind(':user_id' , $data['user_id']);
        $this->db->bind(':title' ,$data['title'] );
        $this->db->bind(':body' , $data['body']);
        $this->db->bind(':created_at' , $created_at);

        if($this->db->execute()) {
            return true;
        }else {
            return false;
        }
    }

    public function findPostById($id)
    {
       $this->db->query("select * from posts where id= :id");

       $this->db->bind(':id' , $id);

       $post = $this->db->single();

       if($post) {
           return $post;
       }else {
           return false;
       }
    }

    public function updatePost($data)
    {
        $this->db->query("update posts set title =:title, body =:body where id = :post_id");

        // Bind values
        $this->db->bind(':post_id' , $data['post']->id);
        $this->db->bind(':title' , $data['title']);
        $this->db->bind(':body', $data['body']);

        if($this->db->execute()){
            return true;
        }else {
            return false;
        }
    }

    public function deletePost($id)
    {
        $this->db->query("delete from posts where id = :post_id");

        $this->db->bind(':post_id' , $id);

        if($this->db->execute()){
            return true;
        }else {
            return false;
        }
    }
}