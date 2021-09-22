<?php

class Posts extends controller {

    public function __construct()
    {
        $this->postModel = $this->model('Post');
    }

    public function index()
    {
        $posts = $this->postModel->findAllPosts();

        $data = [
            'posts' => $posts
        ];

        $this->view('posts/index' , $data);
    }

    public function create()
    {
        if(!isLoggedIn()) {
            header("Location:" . URLROOT ."/public/posts");
        }else {
            $data = [
                'title' => '',
                'body' => '',
                'titleError' => '',
                'bodyError' => ''
            ];

            if($_SERVER['REQUEST_METHOD'] == "POST") {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'user_id' => $_SESSION['user_id'],
                    'title' => trim($_POST['title']),
                    'body' => trim($_POST['body']),
                    'titleError' => '',
                    'bodyError' => ''
                ];

                // Validate title
                if(empty($data['title'])) {
                    $data['titleError'] = "The title of post can not be empty.";
                }

                // Validate body
                if(empty($data['body'])) {
                    $data['bodyError'] = "The body of post can not be empty.";
                }

                if(empty($data['titleError']) && empty($data['bodyError'])) {
                    if($this->postModel->createPost($data)) {
                        header("Location:" . URLROOT. "/public/posts");
                    }else {
                        die("Something went wrong, please try again.");
                    }
                }else {
                    $this->view('posts/create' , $data);
                }
            }
            $this->view('posts/create', $data);
        }
    }

    public function update($id)
    {
        $post = $this->postModel->findPostById($id);

        $data = [
            'post' => $post,
            'title' => '',
            'body' => '',
            'titleError' => '',
            'bodyError' => ''
        ];

        if(!isLoggedIn() or $_SESSION['user_id'] != $post->user_id) {
            header("Location:" . URLROOT. "/public/posts");
        }

        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'post' => $post,
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'titleError' => '',
                'bodyError' => ''
            ];

            // Validate title
            if(empty($data['title'])) {
                $data['titleError'] = "The title of post can not be empty.";
            }

            // Validate body
            if(empty($data['body'])) {
                $data['bodyError'] = "The body of post can not be empty.";
            }

            if(($data['title'] == $data['post']->title) && ($data['body'] == $data['post']->body ))
            {
                $data['bodyError'] =  "Nothing has changed. Please change title or body.";
            }
            if(empty($data['titleError']) && empty($data['bodyError'])) {
                if($this->postModel->updatePost($data)) {
                    var_dump($data);
                    header("Location:" . URLROOT. "/public/posts");
                }else {
                    die("Something went wrong, please try again.");
                }
            }else {
                $this->view('/posts/update' , $data);
            }
        }
        $this->view('/posts/update', $data);
    }

    public function delete($id)
    {
        $post = $this->postModel->findPostById($id);

        if(!isLoggedIn() or $_SESSION['user_id'] != $post->user_id) {
            header("Location:" . URLROOT. "/public/posts");
        }

        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if($this->postModel->deletePost($id)) {
                header("Location:" . URLROOT. "/public/posts");
            }else {
                die("Something went wrong.");
            }
        }else {
            header("Location:" . URLROOT. "/public/posts");
        }
    }
}