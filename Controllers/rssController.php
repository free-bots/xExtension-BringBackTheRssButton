<?php

class FreshExtension_rss_Controller extends FreshRSS_ActionController
{
    public function currentAction()
    {
        try {
            FreshRSS_Context::updateUsingRequest(false);
        } catch (FreshRSS_Context_Exception $e) {
            Minz_Error::error(404);
        }

        try {
            $this->addRssFeed();

            FreshRSS_Context::systemConf()->allow_anonymous = true;

            $this->addRssHeaders();

            $this->view->_layout(null);
            $this->view->_path('index/rss.phtml');
        } catch (FreshRSS_EntriesGetter_Exception $e) {
            Minz_Log::notice($e->getMessage());
            Minz_Error::error(404);
        }
    }

    private function addRssFeed()
    {
        $this->view->entries = FreshRSS_index_Controller::listEntriesByContext();

        $this->view->disable_aside = true;
        $this->view->excludeMutedFeeds = true;
        $this->view->internal_rendering = true;
        $this->view->rss_title = FreshRSS_Context::$name . ' | ' . FreshRSS_View::title();

        $params = [];
        parse_str($_SERVER['QUERY_STRING'], $params);
        unset($params['a']);
        unset($params['c']);
        $baseUrl = Minz_Url::display('', 'html', true) . PUBLIC_TO_INDEX_PATH . '/?';

        $this->view->html_url = $baseUrl . Minz_Helper::htmlspecialchars_utf8(http_build_query($params));

        $params['a'] = 'current';
        $params['c'] = 'rss';

        $this->view->rss_url = $baseUrl . Minz_Helper::htmlspecialchars_utf8(http_build_query($params));

        $this->view->image_url = '';
        $this->view->description = _t('index.feed.rss_of', $this->view->rss_title);
    }

    private function addRssHeaders()
    {
        header('Access-Control-Allow-Methods: GET');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Max-Age: 600');
        header('Cache-Control: public, max-age=60');
        header('Content-Type: application/rss+xml; charset=utf-8');
    }
}
