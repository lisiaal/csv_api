<?php

namespace App\Helper;

class ApiHelper
{
    public function getTeams(?string $parameter, $array)
    {
        //loop through teams and find their parent team
        for ($i = 0; $i < count($array); $i++) {
            for ($j = 0; $j < count($array); $j++) {
                //search if this team has a parent
                if (ucwords($array[$i]['Team']) === ucwords($array[$j]['parent_team'])) {
                    //if it has a parent add it the root team
                    //if parameter exists return the teams with parameter name and its root team
                    if($parameter && $parameter == ucwords($array[$i]['Team']) || $parameter == ucwords($array[$j]['Team'])){
                        $newResponse[$array[$i]['Team']][] = [
                            'team' => $array[$i]['Team'],
                            'parentTeam' => $array[$i]['parent_team'],
                            'managerName' => $array[$i]['manager_name'],
                            'businessUnit' => $array[$i]['business_unit'],
                            'teams' =>
                                $newTeamResponse[$array[$j]['Team']][] = [
                                    'team' => $array[$j]['Team'],
                                    'parentTeam' => $array[$j]['parent_team'],
                                    'managerName' => $array[$j]['manager_name'],
                                    'businessUnit' => $array[$j]['business_unit'],
                                ]
                        ];
                    } else if ($parameter == null){
                        //if parameter does not exist return all the teams
                        $newResponse[$array[$i]['Team']][] = [
                            'team' => $array[$i]['Team'],
                            'parentTeam' => $array[$i]['parent_team'],
                            'managerName' => $array[$i]['manager_name'],
                            'businessUnit' => $array[$i]['business_unit'],
                            'teams' =>
                                $newTeamResponse[$array[$j]['Team']][] = [
                                    'team' => $array[$j]['Team'],
                                    'parentTeam' => $array[$j]['parent_team'],
                                    'managerName' => $array[$j]['manager_name'],
                                    'businessUnit' => $array[$j]['business_unit'],
                                ]
                        ];
                    }

                }
            }

        }

        return $newResponse;
    }
}