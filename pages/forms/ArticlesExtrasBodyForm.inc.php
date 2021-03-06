<?phpimport('form.Form');import('file.ArticleFileManager');class ArticlesExtrasBodyForm extends Form {	/** @var $journalId int */	var $journalId;	/** @var $plugin object */	var $plugin;	/** $var $errors string */	var $errors;	/**	 * Constructor         * @param $journalId int	 */	function ArticlesExtrasBodyForm(&$plugin, $journalId) {		parent::Form($plugin->getTemplatePath() . 'bodyForm.tpl');		$this->journalId = $journalId;		$this->plugin =& $plugin;	}        /**	 * Initialize form data from current group group.	 */	function initData( $args ) {		// figure out the current page 		$current = array_shift($args);		$this->setData('current', $current);		$articlesExtrasDao = &DAORegistry::getDAO('ArticlesExtrasDAO');		$body = $articlesExtrasDao->getArticleBody($current);		// add the tiny MCE script 		//HookRegistry::register('TemplateManager::display',array(&$this, 'callback'));		$templateMgr = &TemplateManager::getManager();		$templateMgr->assign('current', $current );		$templateMgr->assign('currentBody', $body);	}	/**	 * Assign form data to user-submitted data.	 */	function readInputData() {		$this->readUserVars(array('articleBody', 'current'));	}	/**	 * Save page - write to database. 	 */	 	function save() {        	$current = $this->getData('current');		$plugin =& $this->plugin;				//Article		$articleDao = &DAORegistry::getDAO('PublishedArticleDAO');		$article = &$articleDao->getPublishedArticleByArticleId($current, null, false);			//Get body from form		$body = mysql_real_escape_string($this->getData('articleBody'));		//ArticlesExtras DAO		$articleDao = &DAORegistry::getDAO('ArticlesExtrasDAO');		//Set body                $articleDao->setArticleBody($article, $body);	}}?>