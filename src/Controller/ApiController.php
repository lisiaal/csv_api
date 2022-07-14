<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class ApiController extends AbstractController
{
    public function read(Request $request)
    {
        $apiToken = $request->headers->get('X-AUTH-TOKEN');

        if ($apiToken !== $_ENV['API_TOKEN'])
        {
            throw new UserNotFoundException('API Key is not correct');
        }

        $response = array();

        $lines = array_filter(preg_split('/\n|\r\n?/', $request->getContent()));
        $headers = array_shift($lines);

        $array = [];
        foreach ($lines as $line) {
            $array[] = array_combine(explode(',', $headers), explode(',', $line));
        }

        foreach ($array as $arr){
            $key = array_search('C Suit', $arr);
            if($key){
                $response['C Suit'] = array($arr);
                dump($key);
            }
//            dump($key);

//            foreach ($arr as $a){
//                dump($arr);

//            }
        }
//        die;
        dd($response);
    }
}