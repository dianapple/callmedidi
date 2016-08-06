<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Mojde
 * Date: 28/10/13
 * Time: 08:16
 * To change this template use File | Settings | File Templates.
 */

//convert active portfolio terms to id
$catArr  = px_active_portfolio_terms();

//Show category filter either:
//1) There is no category filter assigned
//2) Number of categories are more than one
$catList = '';

if(count($catArr) == 0 || count($catArr) > 1)
{
    $listCatsArgs = array('title_li' => '', 'taxonomy' => 'skills', 'walker' => new PxPortfolioWalker(), 'echo' => 0, 'include' => implode(',', $catArr));
    //$catSep  = '<li class="separator">/</li>';
    $catList = '<li><a class="current" data-filter="*" href="#">'.__('All', TEXTDOMAIN)."</a></li>";
    $catList .= wp_list_categories($listCatsArgs);
    //$catList = remove_last_occurrence($catList, $catSep);
}

//Taxonomy filter
if(count($catArr))
{
    $queryArgs['tax_query'] =  array(
        // Note: tax_query expects an array of arrays!
        array(
            'taxonomy' => 'skills',
            'field'    => 'id',
            'terms'    => $catArr
        ));
}

if(strlen($catList)){ ?>
    <ul class="portfolio-filter pull-right">
        <li>
            <div>
                <span class="text"><?php _e('portfolio filter', TEXTDOMAIN) ?></span>
                <span class="icon icon-angle-down pull-right"></span>
            </div>
            <ul class="portfolio-filter-items">
                <?php echo $catList; ?>
            </ul>
        </li>
    </ul>
<?php } ?>