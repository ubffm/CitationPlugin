<?php

import('lib.pkp.classes.plugins.GenericPlugin');

class UBFFMCitationExtensionsPlugin extends GenericPlugin {
    /**
     * @copydoc Plugin::register()
     */
    public function register($category, $path, $mainContextId = null) {
        $success = parent::register($category, $path, $mainContextId);
        if (!Config::getVar('general', 'installed') || defined('RUNNING_UPGRADE')) return $success;
        if ($success && $this->getEnabled($mainContextId)) {
            HookRegistry::register('CitationStyleLanguage::citationStyleDefaults', array($this, 'addCSLStyle'));
        }
        return $success;
    }

    /**
     * Add a CSL style to the list of default styles
     *
     * @param string $hookname
     * @param array $args [$defaults, CitationStyleLanguagePlugin]
     */
    public function addCSLStyle($hookName, $args) {
        $defaults =& $args[0];
        $path = Core::getBaseDir() . '/' . $this->getPluginPath() . "/citation-styles";
        $defaults[] = array(
            'id' => __('plugins.generic.UBFFMCitationExtensions.style.cte-citation-style'),
            'title' => 'Contributions to Entomolgy Citation Style',
            'isEnabled' => false,
            'useCsl' => $path . '/cte-style.csl'
        );
        $defaults[] = array(
            'id' => __('plugins.generic.UBFFMCitationExtensions.style.generic-style-rules-linguistics'),
            'title' => 'Generic Style Rules for Linguistics',
            'isEnabled' => false,
            'useCsl' => $path . '/generic-style-rules-for-linguistics.csl',
        );
        $defaults[] = array(
            'id' => __('plugins.generic.UBFFMCitationExtensions.style.kochia'),
            'title' => 'Kochia',
            'isEnabled' => true,
            'useCsl' => $path . '/kochia.csl',
        );
    }

    /**
     * @copydoc Plugin::getDisplayName()
     */
    function getDisplayName() {
        return __('plugins.generic.UBFFMCitationExtensions.displayName');
    }

    /**
     * @copydoc Plugin::getDescription()
     */
    function getDescription() {
        return __('plugins.generic.UBFFMCitationExtensions.description');
    }
}

?>
