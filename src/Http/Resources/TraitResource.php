<?php
/**
 * Created by PhpStorm.
 * User: tuvd
 * Date: 2019-03-07
 * Time: 13:35
 */

namespace ViralsBackpack\BackPackAPI\Http\Resources;


trait TraitResource
{
    public function parseIncludes($request)
    {
        if (!$request->has('includes')) {
            return [];
        }

        $includes = explode(',' , $request->get('includes'));
        foreach($includes as $include) {
            $subIncludes = explode('.', $include);
            foreach ($subIncludes as $subInclude) {
                if (!in_array($subInclude, $includes)) {
                    $includes[] = $subInclude;
                }
            }
        }

        return $includes;
    }

    /**
     * @param $request
     * @param $includeItem
     */
    public function hasInclude($request, $includeItem = '')
    {
        $includes = $this->parseIncludes($request);

        return in_array($includeItem, $includes);
    }
}
