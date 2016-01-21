<?php

namespace Landingo\Resources;

class Pagination
{
    private $datasets = array(
        'base_url' => null,
        'active_page' => 1,
        'max' => 10,
        'data_total' => null,
    );

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) 
        {
            if(array_key_exists($key, $this->datasets))
            {
                $this->datasets[$key] = $value;
            }
        }

    }

    public function limit()
    {

        if(!preg_match('/[1-9]/', $this->datasets['active_page']))
        {
            $this->datasets['active_page'] = 1;

        }

        if($this->datasets['active_page'] > $this->pages()['total'])
        {
            $this->datasets['active_page'] = $this->pages()['total'];
        }

        $max = $this->datasets['max'];
        $start = $max * ($this->datasets['active_page'] - 1);

        return $start . ',' . $max;
    }

    public function pages()
    {
        $datasets = $this->datasets;

        $result = array();

        $result['link'] = rtrim($datasets['base_url'], '/');
        $result['total'] = ceil($datasets['data_total'] / $datasets['max']);

        if($datasets['active_page'] > 1)
        {
            $prev = $datasets['active_page'] - 1;
            $result['prev'] = $result['link'] . '/' . $prev;
        }

        if($datasets['active_page'] < $result['total'])
        {
            $next = $datasets['active_page'] + 1;
            $result['next'] = $result['link'] . '/' . $next;
        }        

        return $result;
    }

    public function dataNumbering()
    {
        $result = ($this->datasets['active_page'] * $this->datasets['max']) - ($this->datasets['max'] - 1);

        return $result;
    }

}
