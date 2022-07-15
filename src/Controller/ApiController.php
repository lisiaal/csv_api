<?php

namespace App\Controller;


use App\Helper\ApiHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class ApiController extends AbstractController
{
    /**
     * @var ApiHelper $apiHelper
     * @required
     */
    public ApiHelper $apiHelper;

    public function read(Request $request): JsonResponse
    {
        //check if auth token exists in headers
        $apiToken = $request->headers->get('X-AUTH-TOKEN');

        //check if api token is the same as the one in the ENV
        //symfony would not allow me to create a custom auth without creating a UserProvider
        //so I found this solution
        if ($apiToken !== $_ENV['API_TOKEN'])
        {
            throw new UserNotFoundException('API Key is not correct');
        }

        //get the content of the file
        $lines = array_filter(preg_split('/\n|\r\n?/', $request->getContent()));
        //get only the head of the csv
        $headers = array_shift($lines);

        //get the parameter to filter data
        $parameter = $request->query->get('_q');

        $array = [];
        //combine headers with content
        foreach ($lines as $line) {
            $array[] = array_combine(explode(',', $headers), explode(',', $line));
        }
        $newHeader = array_shift($array);
        //build response for root Team
        $response[$newHeader['Team']][] = [
            'team' => $newHeader['Team'],
            'parentTeam' => $newHeader['parent_team'],
            'managerName' => $newHeader['manager_name'],
            'businessUnit' => $newHeader['business_unit'],
            'teams' => []
        ];

        $newResponse = $this->apiHelper->getTeams($parameter, $array);

        //add child teams to root team
        $response[$newHeader['Team']][0]['teams'] = array($newResponse);
        //return structured JSON response
        return new JsonResponse($response);
    }
}