<?php

namespace WebSiteToYou\App\Controller\Common;

class Start extends \WebSiteToYou\System\Library\Controller {

    public function index(): void {

        $this->document->setTitle($this->config->get('config_meta_title'));
        $this->document->setDescription($this->config->get('config_meta_description'));
        $this->document->setKeywords($this->config->get('config_meta_keyword'));

        $this->loading->model('common/start');

        $getRedis = $this->dbRedis->getQuery('start');

        if ($getRedis):
            $data['resulting_text'] = 'Resulting from Cache';
        else:
            $data['resulting_text'] = 'Resulting from MySQL';
        endif;

        $data['NumRows'] = $this->model_common_start->getNumRows();

        $row = $this->model_common_start->getRow();
        $data['htmlRow'] = 'Array<br>(<br>';
        foreach ($row as $key => $value):
            $data['htmlRow'] .= '<span>[' . $key . ']=> ' . $value . '</span><br>';
        endforeach;
        $data['htmlRow'] .= ')';

        $rows = $this->model_common_start->getRows();
        $data['htmlRows'] = 'Array<br>(<br>';
        foreach ($rows as $keys => $value):
            $data['htmlRows'] .= '<span>[' . $keys . ']=><br><span class="second-level">(</span><br>';
            foreach ($value as $key => $val):
                $data['htmlRows'] .= '<span class="third-level">[' . $key . ']=> ' . $val . '</span><br>';
            endforeach;
            $data['htmlRows'] .= '</span><span class="second-level">)</span><br>';
        endforeach;
        $data['htmlRows'] .= ')';

        $data['clear'] = 'index.php?route=common/start|flushRedis';

        $data['footer'] = $this->loading->controller('common/footer');
        $data['header'] = $this->loading->controller('common/header');

        $this->response->setOutput($this->loading->view('common/start', $data));
    }

    public function flushRedis() {
        $json = [];

        $cacheClear = $this->dbRedis->clearRedisCache();
        
        if($cacheClear == true):
          $json['reload'] = true; 
        endif;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

}
