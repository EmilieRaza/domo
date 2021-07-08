<?= "<?php\n" ?>

namespace <?= $namespace ?>;

use <?= $entity_full_class_name ?>;
use <?= $form_full_class_name ?>;
<?php if (isset($repository_full_class_name)): ?>
use <?= $repository_full_class_name ?>;
<?php endif ?>

use Symfony\Bundle\FrameworkBundle\Controller\<?= $parent_class_name ?>;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin<?= $route_path ?>")
 */
class <?= $class_name ?> extends <?= $parent_class_name; ?><?= "\n" ?>
{
    /**
     * @Route("/", name="<?= $route_name ?>_search", methods="GET")
     */
<?php if (isset($repository_full_class_name)): ?>
    public function search(<?= $repository_class_name ?> $<?= $repository_var ?>): Response
    {
        return $this->render('back/<?= $templates_path ?>/search.html.twig', [
            '<?= $entity_twig_var_plural ?>' => $<?= $repository_var ?>->findAll(), 
            'slug'=>'<?= $route_name ?>', 
        ]);
    }
<?php endif ?>

    /**
     * @Route("/create", name="<?= $route_name ?>_create", methods="GET|POST")
     */
    public function create(Request $request): Response
    {
        $<?= $entity_var_singular ?> = new <?= $entity_class_name ?>();
        $form = $this->createForm(<?= $form_class_name ?>::class, $<?= $entity_var_singular ?>);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($<?= $entity_var_singular ?>);
            $em->flush();

            return $this->redirectToRoute('<?= $route_name ?>_search');
        }

        return $this->render('back/<?= $templates_path ?>/create.html.twig', [
            '<?= $entity_twig_var_singular ?>' => $<?= $entity_var_singular ?>,
            'form' => $form->createView(),
            'slug'=>'<?= $route_name ?>',
        ]);
    }

    /**
     * @Route("/{<?= $entity_identifier ?>}", name="<?= $route_name ?>_read", methods="GET")
     */
    public function read(<?= $entity_class_name ?> $<?= $entity_var_singular ?>): Response
    {
        return $this->render('back/<?= $templates_path ?>/read.html.twig', [
        '<?= $entity_twig_var_singular ?>' => $<?= $entity_var_singular ?>, 
            'slug'=>'<?= $route_name ?>',
        ]);
    }

    /**
     * @Route("/update/{<?= $entity_identifier ?>}", name="<?= $route_name ?>_update", methods="GET|POST")
     */
    public function update(Request $request, <?= $entity_class_name ?> $<?= $entity_var_singular ?>): Response
    {
        $form = $this->createForm(<?= $form_class_name ?>::class, $<?= $entity_var_singular ?>);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('<?= $route_name ?>_search');
        }

        return $this->render('back/<?= $templates_path ?>/update.html.twig', [
            '<?= $entity_twig_var_singular ?>' => $<?= $entity_var_singular ?>,
            'form' => $form->createView(),
            'slug'=>'<?= $route_name ?>',
        ]);
    }

    /**
     * @Route("/delete/{<?= $entity_identifier ?>}", name="<?= $route_name ?>_delete", methods="DELETE")
     */
    public function delete(Request $request, <?= $entity_class_name ?> $<?= $entity_var_singular ?>): Response
    {
            $msg = 'Enregistrement supprimé avec succès';
            $em = $this->getDoctrine()->getManager();
            $em->remove($<?= $entity_var_singular ?>);
            $em->flush();
            $this->addFlash('success', $msg);
            return $this->redirectToRoute('<?= $route_name ?>_search');
    }
}