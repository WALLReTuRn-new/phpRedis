<?php

namespace WebSiteToYou\App\Controller\Common;

class Header extends \WebSiteToYou\System\Library\Controller {

    public function index(): string {




        $this->loading->language('common/header');

        $data['lang'] = $this->language->get('code');
        $data['direction'] = $this->language->get('direction');

        $data['title'] = $this->document->getTitle();
        $data['base'] = $this->config->get('config_url');
        $data['description'] = $this->document->getDescription();
        $data['keywords'] = $this->document->getKeywords();

        // Hard coding css so they can be replaced via the event's system.
        $data['bootstrap'] = 'app/views/' . $this->config->get('config_theme') . 'assets/css/bootstrap-5.2.3-dist/css/bootstrap.min.css';
        $data['icons'] = 'app/views/' . $this->config->get('config_theme') . 'assets/css/fontawesome-free-6.2.1-web/css/all.min.css';
        $data['stylesheet'] = 'app/views/' . $this->config->get('config_theme') . 'assets/css/style.css';

        // Hard coding scripts so they can be replaced via the event's system.
        $data['jquery'] = 'app/views/' . $this->config->get('config_theme') . 'assets/js/jquery-3.6.1.min.js';

        $data['links'] = $this->document->getLinks();
        $data['styles'] = $this->document->getStyles();
        $ScriptResult = $this->document->getScripts('header');

        foreach ($ScriptResult as $key => $result):
            $data['scripts'][] = [
                'name' => $key,
                'href' => $result
            ];
        endforeach;

        return $this->loading->view('common/header', $data);
    }

}
