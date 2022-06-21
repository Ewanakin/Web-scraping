<?php

namespace App\Controller;

use App\Entity\Link;
use App\Entity\Search;
use App\Entity\Content;
use App\Entity\Image;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScraperController extends AbstractController
{
    #[Route('/scraper/search', name: 'app_scraper')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $search = $doctrine->getRepository(Search::class)->findAll();
        return $this->render('scraper/index.html.twig', [
            'search' => $search,
        ]);
    }

    #[Route('/scraper/search/link/{id}', name: 'link_search')]
    public function indexLink(ManagerRegistry $doctrine, $id): Response
    {
        $link = $doctrine->getRepository(Link::class)->findBy(array("fk_id_search" => $id));
        return $this->render('scraper/link.html.twig', [
            'link' => $link,
        ]);
    }
    #[Route('/scraper/search/link/page/{id}', name: 'page_link')]
    public function indexPage(ManagerRegistry $doctrine, $id): Response
    {
        $content = $doctrine->getRepository(Content::class)->findBy(array("fk_id_link" => $id));
        $image = $doctrine->getRepository(Image::class)->findBy(array("fk_link" => $id));
        return $this->render('scraper/page.html.twig', [
            'content' => $content,
            'image' => $image,
        ]);
    }
}
