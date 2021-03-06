<?php

require '../app/Entity/QCM.php';

class QcmManager
{
    private $pdo;

    public function __construct()
    {
        try
        {
            $this->pdo = new PDO('mysql:host=localhost;dbname=my_qcm_generator','root');
        }
        catch(PDOException $e)
        {
            echo 'Error : ' . $e->getMessage();
            die;
        }
    }

    public function getAll()
    {
        $sql = 'SELECT * FROM qcm';
        $req = $this->pdo->prepare($sql);
        $req->execute();
        $qcms = $req->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach($qcms as $qcm)
        {
            $obj = new QCM();
            $obj->setId($qcm['id']);
            $obj->setTitle($qcm['title']);
            $result[] = $obj;
        }

        return $result;
    }

    public function get(int $id) : QCM
    {
        $sql = "SELECT * FROM qcm WHERE id = :id";
        $req = $this->pdo->prepare($sql);
        $req->execute([
            'id' => $id
        ]);
        $result = $req->fetch(PDO::FETCH_ASSOC);
        
        $qcm = (new QCM())
            ->setId($result['id'])
            ->setTitle($result['title']);

        return $qcm;
    }


    public function insert(string $title) : int
    {
        $sql = "INSERT INTO qcm (title) VALUES (:title)";
        $req = $this->pdo->prepare($sql);
        $req->execute([
            'title' => $title,
        ]);

        return $this->pdo->lastInsertId();
    }


    public function update(string $title, int $id)
    {
        $sql = "UPDATE qcm SET title = :title WHERE id = :id";
        $req = $this->pdo->prepare($sql);
        $req->execute([
            'title' => $title,
            'id' => $id
        ]);
    }

    
    public function delete(int $id)
    {
        $sql = "DELETE FROM qcm WHERE qcm.id = :id";
        $req = $this->pdo->prepare($sql);
        $req->execute([
            'id' => $id,
        ]);
    }
}