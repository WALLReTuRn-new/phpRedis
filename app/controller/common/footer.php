<?php

namespace WebSiteToYou\App\Controller\Common;

class Footer extends \WebSiteToYou\System\Library\Controller {

    public function index(): string {






       
        $data['jpopper'] = 'app/views/' . $this->config->get('config_theme') . 'assets/js/popper.min.js';
        $data['jbootstrap'] = 'app/views/' . $this->config->get('config_theme') . 'assets/css/bootstrap-5.2.3-dist/js/bootstrap.min.js';
        $data['jcommon'] = 'app/views/' . $this->config->get('config_theme') . 'assets/js/common.js';

        $ScriptResult = $this->document->getScripts('footer');

        foreach ($ScriptResult as $key => $result):
            $data['scripts'][] = [
                'name' => $key,
                'href' => $result
            ];
        endforeach;

        return $this->loading->view('common/footer', $data);
    }

}
