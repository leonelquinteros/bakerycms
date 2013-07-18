<?php
class PagesAjaxController extends PagesAppController
{
	public $name = 'PagesAjax';
	public $uses = array();
	public $components = array('CmsLogin');
	public $helpers = array();
	
	
	public function beforeFilter()
	{
		// Disables browser cache
		$this->disableCache();
		
		// Checks login
		$this->CmsLogin->checkAdminLogin();
		
		// Disable layout
		$this->layout = false;
		$this->autoRender = false;
	}
	
	public function html_entities_decode()
	{
		if(!empty($_POST['html'])) {
			echo html_entity_decode($_POST['html'], ENT_NOQUOTES, 'UTF-8');
		}
	}
	
	public function save_page_content($pageId = 0)
	{
		App::import('Model', 'Pages.PagesPageContent');
		
		$pageContent = new PagesPageContent();
		
		// Save content
		$pageContent->saveContent($_POST, $pageId);
	}
	
	public function page_add_menu($pageId, $menuName, $menuLang)
	{
		App::import('Model', 'Pages.PagesPage');
		$page = new PagesPage();
		
		App::import('Model', 'Menus.MenusMenu');
		$menu = new MenusMenu();
		
		$pageData = $page->findById($pageId);
		
		$menuData = $menu->create();
		$menuData['MenusMenu']['name'] = $menuName;
		$menuData['MenusMenu']['lang'] = $menuLang;
		$menuData['MenusMenu']['title'] = $pageData['PagesPage']['title'];
		$menuData['MenusMenu']['link'] = '/' . $pageData['PagesPage']['url'];
		$menuData['MenusMenu']['position'] = 9999;
		$menuData['MenusMenu']['parent_id'] = 0;
		
		$menu->save($menuData);
		
		// Returns the inserted ID to allow the JS callback to transform the "add" into a "remove".
		echo $menu->id;
	}
	
	public function page_remove_menu($idMenu)
	{
		App::import('Model', 'Menus.MenusMenu');
		
		$menu = new MenusMenu();
		$menu->delete($idMenu);
	}
	
	public function page_keywords($idPage)
	{
		$exclude = array();
		$exclude['eng'] = array('on', 'in', 'at', 'since', 'for', 'ago', 'before', 'to', 'past', 'till', 'until', 'by', 'in', 'at', 'on', 'by', 'next to',
								'beside', 'under', 'below', 'over', 'above', 'across',	'through', 'to', 'into' , 'towards', 'onto', 'from', 'of', 'by', 'on', 'in', 'off', 'by', 'at', 'about',
								'according', 'to','after','although','and','as','if','because','before','both','and','but','either','even','except','for','furthermore','however',
								'if','moreover','namely','nither','nevertheless','nor','notwithstanding','or','otherwhise','provided','providing','since',
								'still','than','therefore','though','unless','until','whenever','whereas','whether','whether','while','yet',
								'i','you','he','she','it','we','you','they'
		);
		
		$exclude['dut'] = array('aan','aangaande','ad','achter','af','bachten','een', 'gewestelijk', 'voornamelijk','behalve','behoudens','beneden',
								'benevens','benoorden','beoosten','betreffende', 'bewesten','bezijden','bezuiden','bij','binnen','blijkens','boven','buiten','circa','conform',
								'contra','cum', 'dankzij', 'de','door','doorheen','gedurende','gezien','hangende','in','ingevolge','inzake','jegens','krachtens','langs',
								'langsheen','luidens','met','middels','midden','mits','na','naar','naast','nabij','namens','nevens','niettegenstaande','nopens','om','omstreeks',
								'omtrent','ondanks','onder','ongeacht','onverminderd','op','over','overeenkomstig','per','plus','post','richting','rond','rondom','sedert',
								'sinds','staande','te','tegen','tegenover','ten','ter','tijdens','tot','trots','tussen','uit','uitgezonderd','van','vanaf','vanuit','vanwege',
								'versus','via','via-a-vis', 'volgens','voor','voorbij','wegens','zonder',
								'aangezien','al','alhoewel','als','alsof','alvorens','daar','dat','door','doordat','en','evenals','hetzij','hoewel','maar','maar','toch','mits',
								'nadat','noch','of','ofschoon','ofwel','omdat','opdat','telkens als','telkens wanneer','tenzij','terwijl','toch','toen','wanneer','zoals','zodat','zodra',
								'ik','jij','u','zij','ze','hij','het','wij','jullie','zig','u','mij','jou','u','hem','haar','ons','hun','hen','ze'
		);
		
		$exclude['esp'] = array('a', 'ante', 'bajo', 'con', 'contra', 'de', 'desde', 'en', 'entre', 'hacia', 'hasta', 'para', 'por', 'según', 'sin', 'so', 'sobre', 'tras', 'durante', 'mediante',
								'y', 'e', 'ni', 'mas', 'pero', 'sino', 'que', 'o', 'u', 'porque', 'pues', 'puesto', 'si', 'tal', 'aunque', 'así', 'como', 'tan', 'tanto', 'cuando', 'antes', 'siempre',
								'yo','tu','tú','vos','usted','el','él','ella','ello','nosotros','nosotras','vosotros','vosotras','ustedes','ellos','ellas','mi','conmigo','ti','contigo','si','consigo',
								'me','te','lo','la','le','se','nos','os','los','las','les','se'
		);
		
		$idPage = (int) $idPage;
		
		App::import('Model', 'Pages.PagesPage');
		App::import('Model', 'Pages.PagesPageContent');
		
		$page = new PagesPage();
		$pageC = new PagesPageContent();
		
		$aWords = array();
		$aKeywords = array();
		
		$pageData = $page->findById($idPage);
		if(!empty($pageData))
		{
			$pageContent = $pageC->find('all', array('conditions' => array('PagesPageContent.pages_pages_id' => $idPage)) );
			
			$contentString = '';
			foreach($pageContent as $content)
			{
				$contentString .= ' ' . strip_tags($content['PagesPageContent']['content']);
			}
			
			// The title and URL twice to increment value.
			$aWords = str_word_count(strtolower($pageData['PagesPage']['title'] . ' ' . $pageData['PagesPage']['title'] . ' ' .
										$pageData['PagesPage']['title'] . ' ' . $pageData['PagesPage']['title'] . ' ' . $contentString), 1);
			
			if(!empty($exclude[$pageData['PagesPage']['lang']]))
			{
				$aKeywords = array_count_values( array_diff($aWords, $exclude[$pageData['PagesPage']['lang']]) );
			}
			else
			{
				$aKeywords = array_count_values($aWords);
			}
			
			arsort($aKeywords);
			
			$i = 0;
			foreach($aKeywords as $keyword => $count)
			{
				$i++;
				$size = 1 + (0.2 * $count);
				echo "<a href='#' onclick='insertKeyword(this); return false;' style='font-size:" . $size . "em;'>$keyword</a><sup>($count)</sup> ";
				
				if($i >= 15 || $count == 1)
				{
					break;
				}
			}
		}
	}
	
	public function get_link_page_options()
	{
		// Enable layout
		$this->layout = 'empty';
		$this->autoRender = true;
		
		App::import('Model', 'Pages.PagesPage');
		$page = new PagesPage();
		
		$pages = $page->find('all', array('order' => 'PagesPage.title', 'conditions' => array('PagesPage.publish = 1')));
		$this->set('pages', $pages);
	}
}
