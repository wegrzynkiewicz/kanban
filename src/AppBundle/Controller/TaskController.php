<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    /**
     * @Route("/task/add", name="task_add")
     */
    public function addAction(Request $request)
    {
        $content = $request->getContent();
        $data = json_decode($content, true);
        if (!$data) {
            return $this->redirectToRoute('dashboard');
        }

        $task = new Task();
        $task->title = $data['title'];
        $task->details = $data['details'];
        $task->creation_date = new DateTime("now");
        $task->type = $data['type'];

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($task);
        $entityManager->flush();

        return new Response(null, 204);
    }

    /**
     * @Route("/task/edit", name="task_edit")
     */
    public function editAction(Request $request)
    {
        $content = $request->getContent();
        $data = json_decode($content, true);
        if (!$data) {
            return $this->redirectToRoute('dashboard');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $id = $data['task_id'];
        $task = $entityManager->getRepository(Task::class)->find($id);

        if (!$task) {
            throw $this->createNotFoundException(
                "No task found for id {$id}"
            );
        }

        $task->title = $data['title'];
        $task->details = $data['details'];
        $task->type = $data['type'];

        $entityManager->flush();

        return new Response(null, 204);
    }

    /**
     * @Route("/task/delete", name="task_delete")
     */
    public function deleteAction(Request $request)
    {
        $content = $request->getContent();
        $data = json_decode($content, true);
        if (!$data) {
            return $this->redirectToRoute('dashboard');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $id = $data['task_id'];
        $task = $entityManager->getRepository(Task::class)->find($id);

        if (!$task) {
            throw $this->createNotFoundException(
                "No task found for id {$id}"
            );
        }

        $entityManager->remove($task);
        $entityManager->flush();

        return new Response(null, 204);
    }

    /**
     * @Route("/task/all", name="task_all")
     */
    public function allAction(Request $request)
    {
        $content = $request->getContent();
        $data = json_decode($content, true);
        if (!$data) {
            return $this->redirectToRoute('dashboard');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery("
            SELECT 
              task.task_id,              
              task.title,
              task.details,
              task.creation_date,
              task.type
            FROM AppBundle\\Entity\\Task task
            WHERE task.title LIKE :title 
              OR task.details LIKE :details"
        )->setParameter('title', "%{$data['query_text']}%")
            ->setParameter('details', "%{$data['query_text']}%");

        $products = $query->execute();

        return new JsonResponse($products);
    }
}
