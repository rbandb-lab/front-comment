<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Post;
use App\Model\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class InMemoryPostRepository implements PostRepository
{
    private Collection $posts;
    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $post1 = new Post(1);
        $author1 = new User(
            id: '1',username: 'john',email: 'john.doe@example.com'
        );
        $author2 = new User(
            id: '2',username: 'john',email: 'john.doe@example.com'
        );

        $post1->setContent("<p>Lorem Salu bissame ! Wie geht's les samis ? Hans apporte moi une Wurschtsalad avec un picon bitte, s'il te plaît.
  Voss ? Une Carola et du Melfor ? Yo dû, espèce de Knäckes, ch'ai dit un picon !</p>
<p>Hopla vous savez que la mamsell Huguette, la miss Miss Dahlias du messti de Bischheim était au Christkindelsmärik en compagnie de Richard Schirmeck (celui qui a un blottkopf), le mari de Chulia Roberstau, qui lui trempait sa Nüdle dans sa Schneck ! Yo dû, Pfourtz ! Ch'espère qu'ils avaient du Kabinetpapier, Gal !</p>
<p>Yoo ch'ai lu dans les DNA que le Racing a encore perdu contre Oberschaeffolsheim. Verdammi et moi ch'avais donc parié deux knacks et une flammekueche. Ah so ? T'inquiète, ch'ai ramené du schpeck, du chambon, un kuglopf et du schnaps dans mon rucksack. Allez, s'guelt ! Wotch a kofee avec ton bibalaekaess et ta wurscht ? Yeuh non che suis au réchime, je ne mange plus que des Grumbeere light et che fais de la chym avec Chulien. Tiens, un rottznoz sur le comptoir.</p>
<p>Tu restes pour le lotto-owe ce soir, y'a baeckeoffe ? Yeuh non, merci vielmols mais che dois partir à la Coopé de Truchtersheim acheter des mänele et des rossbolla pour les gamins. Hopla tchao bissame ! Consectetur adipiscing elit</p>");
        $post1->setAuthor($author1);
        $post1->setSlug("hopla-elsass-1");
        $post1->setSummary("Lorem Salu");
        $post1->setTitle("Title 1");


        $post2 = new Post(2);
        $post2->setContent("Hopla vous savez que la mamsell Huguette, la miss Miss Dahlias du messti de Bischheim était en compagnie de Richard Schirmeck (celui qui a un blottkopf), le mari de Chulia Roberstau, qui lui trempait sa Nüdle dans sa Schneck ! Yo dû, Pfourtz !");
        $post2->setAuthor($author2);
        $post2->setSlug("hopla-elsass-2");
        $post2->setSummary("Lorem Salu");
        $post2->setTitle("Title 2");

        $this->posts->add($post1);
        $this->posts->add($post2);
    }


    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function find(int $id): ?Post
    {
        foreach ($this->posts->getIterator() as $article) {
            if ($article->getId() === $id) {
                return $article;
            }
        }
        return null;
    }
}