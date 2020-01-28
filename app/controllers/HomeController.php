<?php
namespace App\controllers;

use App\models\QueryBuilder;
use League\Plates\Engine;
use Aura\SqlQuery\QueryFactory;
use PDO;


class HomeController
{
    private $view;
    private $queryFactory;
    private $pdo;

    public function __construct(Engine $view, QueryFactory $queryFactory, PDO $pdo)
    {
        $this->view = $view;
        $this->queryFactory = $queryFactory;
        $this->pdo = $pdo;
    }

    public function index()
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(["*"])
            ->from('tasks');

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $myTasks = $sth->fetchAll(PDO::FETCH_ASSOC);

        echo $this->view->render('tasks', ['tasks' => $myTasks]);
    }


    public function show($id)
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(["*"])
            ->from('tasks')
            ->where('id=:id')
            ->bindValues(['id'  =>  $id]);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $myTask = $sth->fetch(PDO::FETCH_ASSOC);

        echo $this->view->render('show', ['task' => $myTask]);
    }

}
