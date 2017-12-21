<?php
// PRODUCT_ID_TRENDSTOP
// This fileis no longer used on web, so wen play with it inside 
// members/
// remember the switch on the controller index.php
/**
 * pgeMain.php
 * SiteWebPageMembers
 *
 * @author Fabiana Faria
 * @version 1.0
 * @since 20080516
 */
require_once 'lib/afl/socnet/web/trendstop/SiteWebPageMembers.php';
class PageMarkup extends ViewTemplate {
	public function __construct($oView) {
		$oView->setPageSize ( 'full' );
		$oView->startHeadContent ();
		// $this->addJavaScript("trendstop/tabs.js");
		$oView->addStyleSheet ( CDN_URL_CSS . "/members_home.css" );
		$oView->addStyleSheet ( CDN_URL_CSS . "/shared.css" );
		$oView->addJavaScript ( CDN_URL_JS . "/jquery/jquery.carousel.min.js", WebPage::FOOTER_JS );
		$oView->addJavaScript ( CDN_URL_JS . "/trendstop/members/main.js", WebPage::FOOTER_JS );
		$oView->addJavaScript ( CDN_URL_JS . "/trendstop/members/mainbeta.js", WebPage::FOOTER_JS );
		$oView->addStyleSheet ( CDN_URL_CSS . "/content_tour.css" );
		$oView->setTitle ( Gender::getGenderName () . ' - Members - Home' );
		$oView->addJavaScript ( CDN_URL_JS . "/handlebars-v2.0.0.js" );
		
		?>

<script id="entry-template" type="text/x-handlebars-template">

<div class="{{no_access_css}} single_item_box single_item_large  fleft" data-sort="{{display_date}}">
	<a class="single_item_box_link single_item_large " href="{{link}}" title="{{caption}}">
       <span class="item_box">
           <span class="item_img_holder">
                   <img src="{{image}}" alt="{{caption}}">
					{{#if spotted}}
   						<span class="trend_info_bg light_opacy_bg trend_info_bg1"></span>
                   			<span class="trend_info trend_info1">
                       		<span class="flag_item_box_skin flag_item_box_icon flag_item_box_spotted"></span>
                       		<span class="flag_item_box_title lower">Spotted</span>
                   		</span>
  					{{/if}}

			        {{#if gallery_type}}
						<span class="item_indicator" data-type="gallery_images"  title="Gallery Images">
							<span class="item_indicator__icon"></span>
						</span>
                    {{else}}
				    	{{#if page_download}}
							<span class="item_indicator" data-type="extra_research" title="Extra Research">
								<span class="item_indicator__icon"></span>
							</span>
                        {{else}}
                            {{#if download}}
							<span class="item_indicator" data-type="artwork_download" title="Artwork Downloads">
								<span class="item_indicator__icon"></span>
							</span>
					        {{/if}}

					    {{/if}}

						
 						<!--{{#if is_page}}
							<span class="item_indicator" data-type="single_page" title="Single Page">
								<span class="item_indicator__icon"></span>
							</span>
					     {{/if}} //-->


					{{/if}}
						
					

					
           </span>
           <span class="item_more_info lower">
				<span>{{title}}</span>
          </span>
      </span>
      <span>
		  <span class="item_season">{{category_name}}</span>
          <span class="item_date">{{season_name}}</span>
          <span class="item_date">{{create_date}}   {{updated}}</span>
      </span>
	</a>
 
</div>


</script>
<?php
		$oView->endHeadContent ();
	}
	public function display() {
		$data = $this->getParameter ( "data" );
		if (isset ( $data ))
			extract ( $data );
		
		$sGender = $this->getParameter ( 'gender' );
		$aStories = $this->getParameter ( 'stories', array () );
		$aStoriesNav = $this->getParameter ( 'storiesNav', array () );
		$aLatestAll = $this->getParameter ( 'latestAll', array () );
		
		// Variables
		$sTitle = gettext ( 'latest in ' ) . gettext ( ($sGender == 'w') ? "womenswear" : "menswear" );
		
		self::displayMainStoriesList ( $aStories, $aStoriesNav );
		
		?>

<!-- React markup -->
<div class="react-component" component-name='TestComponent' id="testing"></div>
<div class="react-component" component-name='MyComponent' id="my-component"></div>
<div class="react-component root" component-name='App'></div>
<div class="react-component" component-name='RanTest' mydata='this is my data'></div>
<div class="react-component" component-name='RanTest2'></div>

<div class='members_area_home' data-info-visible="false">

	<h1 class="member__main__page-title">TITLE:<?php echo $sTitle; ?></h1>



	<div id="toggle-info" class="member__main__toggle-info">
		<div class="member__main__toggle-button"
			onclick="toggleAttribute('data-info-visible')">
			<svg width="18" height="18" viewbox="0 0 24 24">
				<path
					d="M7.57,19.991c1.112-3.527,3.218-7.752,3.59-8.821c0.539-1.55-0.417-2.24-3.43,0.412c-0.193-0.39-0.465-0.834-0.67-1.261c3.438-3.741,10.518-4.585,8.109,1.209c-1.505,3.619-2.581,6.06-3.196,7.942c-0.896,2.747,1.369,1.635,3.586-0.415c0.302,0.494,0.4,0.652,0.704,1.22C11.335,24.966,5.87,25.379,7.57,19.991z M16.918,3.886c-1.049,0.893-2.603,0.873-3.471-0.043c-0.869-0.917-0.724-2.381,0.323-3.274c1.048-0.892,2.601-0.872,3.471,0.043C18.108,1.529,17.966,2.994,16.918,3.886z" /></svg>
			<svg width="18" height="18" viewbox="0 0 24 24">
				<path
					d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"></path></svg>
		</div>
	</div>

	<div class="members_info-box">
		<div class="members_info__col">
			<h4 class="members_info__title">Welcome to our new look homepage for <?php echo $sGender == 'w' ? "Womenswear" : "Menswear" ?></h4>
			<p>Here you will find all the latest content updates published across
				the site covering all categories.</p>
			<p class="members_info__bottom">
				Check the <a
					href="<?php echo PageContext::getUrl(array('members', 'schedule'))?>">Publishing
					Schedule</a> to see when reports important to you will be
				published.
			</p>
		</div>
		<div class="members_info__col">
			<h4 class="members_info__title">Key</h4>
			<ul class="members_info__legend-list">
				<li class="members_info__legend" data-type="artwork_download">
					<div class="members_info__legend-icon"></div>
					<div class="members_info__legend-desc">
						<strong>Artwork Downloads</strong> included in this report
					</div>
				</li>
				<li class="members_info__legend" data-type="extra_research">
					<div class="members_info__legend-icon"></div>
					<div class="members_info__legend-desc">
						<strong>Extra Research</strong> included in this report
					</div>
				</li>
				<li class="members_info__legend" data-type="gallery_images">
					<div class="members_info__legend-icon"></div>
					<div class="members_info__legend-desc">
						<strong>Gallery Images</strong>
					</div>
				</li>
			</ul>
		</div>
	</div>


</div>

<div id="homepageContent" data-gender="<?php echo $sGender; ?>">

	<div class="members_main__loading-icon">
		<svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg"
			xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			width="40px" height="40px" viewBox="0 0 40 40"
			enable-background="new 0 0 40 40" xml:space="preserve">
				  <path opacity="0.2" fill="#000"
				d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946
				    s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634
				    c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"></path>
				  <path fill="#000"
				d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0
				    C22.32,8.481,24.301,9.057,26.013,10.047z"
				transform="rotate(360 -2.02720e-8 -2.02719e-8)">
				    <animateTransform attributeType="xml" attributeName="transform"
				type="rotate" from="0 20 20" to="360 20 20" dur="0.5s"
				repeatCount="indefinite"></animateTransform>
				    </path>
				</svg>
	</div>

</div>

<!-- 5croll Top Button jQuery -->
<a class="to-top-btn" id="scrollTop" href = "#">
	<i class="arrowUp"></i>
</a>

<?php
	}
	
	/*
	 * <div class="entry">
	 * <h1>{{title}}</h1>
	 * <div class="body">
	 * {{body}}
	 * </div>
	 * </div>
	 */
	public static function displayMainStoriesList($aStories, $aStoriesNav) {
		$iCurrectStory = 1;
		$aCurrentStory = $aStories [0];
		
		?>
<!-- Content Tour Start -->
<div class='banner_item banner_img'>
        
         <?php self::displayMainStoriesContext($aStories, $iCurrectStory); ?>
    </div>
<!-- Content Tour End -->
<?php
	}
	private static function displayMainStoriesContext($aStories, $iCurrent) {
		?>

<div id="carousel" class="header_carousel js" tabindex="0">

	<ul class="clearfix">
		<?php foreach($aStories as $aStory) { ?>
		    <li class="image_holder">
		    	<a href="<?php echo $aStory['LinkUrl']; ?>"><img class="full" src='<?php echo $aStory['CssBgLarge']; ?>' alt='<?php echo $aStory['CssBg']; ?>' /></a>
		    </li>
		<?php } ?>
	</ul>
</div>


<?php
	}
}