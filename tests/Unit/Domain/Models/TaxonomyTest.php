<?php

declare(strict_types=1);

namespace Pollora\Entity\Tests\Unit\Domain\Models;

use PHPUnit\Framework\TestCase;
use Pollora\Entity\Domain\Models\Taxonomy;
use function absint;

class TaxonomyTest extends TestCase
{
    public function testCreateTaxonomyWithMinimalProperties(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');

        $this->assertEquals('genre', $taxonomy->getSlug());
        $this->assertEquals('book', $taxonomy->getObjectType());
        $this->assertEquals('Genre', $taxonomy->getSingular());
        $this->assertEquals('Genres', $taxonomy->getPlural());
        $this->assertFalse($taxonomy->isHierarchical());
        $this->assertTrue($taxonomy->isPublic());
        $this->assertTrue($taxonomy->isShowUi());
        $this->assertTrue($taxonomy->isShowInMenu());
        $this->assertTrue($taxonomy->isShowInNavMenus());
        $this->assertTrue($taxonomy->isShowTagcloud());
        $this->assertTrue($taxonomy->isShowInQuickEdit());
        $this->assertTrue($taxonomy->isShowAdminColumn());
        $this->assertFalse($taxonomy->isShowInRest());
        $this->assertNull($taxonomy->getRestBase());
        $this->assertNull($taxonomy->getRestControllerClass());
        $this->assertNull($taxonomy->getCapabilities());
        $this->assertNull($taxonomy->getDefaultTerm());
        $this->assertNull($taxonomy->getAdminCols());
    }

    public function testCreateTaxonomyWithStaticMake(): void
    {
        $taxonomy = Taxonomy::make('genre', 'book', 'Genre', 'Genres');

        $this->assertEquals('genre', $taxonomy->getSlug());
        $this->assertEquals('book', $taxonomy->getObjectType());
        $this->assertEquals('Genre', $taxonomy->getSingular());
        $this->assertEquals('Genres', $taxonomy->getPlural());
    }

    public function testSetLabels(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');
        $labels = [
            'name' => 'Genres',
            'singular_name' => 'Genre',
            'menu_name' => 'Genres',
            'all_items' => 'All Genres',
            'edit_item' => 'Edit Genre',
            'view_item' => 'View Genre',
            'update_item' => 'Update Genre',
            'add_new_item' => 'Add New Genre',
            'new_item_name' => 'New Genre Name',
            'parent_item' => 'Parent Genre',
            'parent_item_colon' => 'Parent Genre:',
            'search_items' => 'Search Genres',
            'popular_items' => 'Popular Genres',
            'separate_items_with_commas' => 'Separate genres with commas',
            'add_or_remove_items' => 'Add or remove genres',
            'choose_from_most_used' => 'Choose from the most used genres',
            'not_found' => 'No genres found',
            'no_terms' => 'No genres',
            'filter_by_item' => 'Filter by genre',
            'items_list_navigation' => 'Genres list navigation',
            'items_list' => 'Genres list',
            'back_to_items' => '← Back to Genres',
            'item_link' => 'Genre Link',
            'item_link_description' => 'A link to a genre',
        ];

        $taxonomy->setLabels($labels);

        $this->assertEquals($labels, $taxonomy->getLabels());
    }

    public function testSetDescription(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');
        $description = 'Book genres';

        $taxonomy->setDescription($description);

        $this->assertEquals($description, $taxonomy->getDescription());
    }

    public function testSetPublic(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');

        $taxonomy->setPublic(false);

        $this->assertFalse($taxonomy->isPublic());
    }

    public function testSetHierarchical(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');

        $taxonomy->setHierarchical(true);

        $this->assertTrue($taxonomy->isHierarchical());
    }

    public function testSetShowUi(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');

        $taxonomy->setShowUi(false);

        $this->assertFalse($taxonomy->isShowUi());
    }

    public function testSetShowInMenu(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');

        $taxonomy->setShowInMenu(false);

        $this->assertFalse($taxonomy->isShowInMenu());
    }

    public function testSetShowInNavMenus(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');

        $taxonomy->setShowInNavMenus(false);

        $this->assertFalse($taxonomy->isShowInNavMenus());
    }

    public function testSetShowTagcloud(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');

        $taxonomy->setShowTagcloud(false);

        $this->assertFalse($taxonomy->isShowTagcloud());
    }

    public function testSetShowInQuickEdit(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');

        $taxonomy->setShowInQuickEdit(false);

        $this->assertFalse($taxonomy->isShowInQuickEdit());
    }

    public function testSetShowAdminColumn(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');

        $taxonomy->setShowAdminColumn(false);

        $this->assertFalse($taxonomy->isShowAdminColumn());
    }

    public function testSetShowInRest(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');

        $taxonomy->setShowInRest(true);

        $this->assertTrue($taxonomy->isShowInRest());
    }

    public function testSetRestBase(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');
        $restBase = 'genres';

        $taxonomy->setRestBase($restBase);

        $this->assertEquals($restBase, $taxonomy->getRestBase());
    }

    public function testSetRestControllerClass(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');
        $controllerClass = 'WP_REST_Terms_Controller';

        $taxonomy->setRestControllerClass($controllerClass);

        $this->assertEquals($controllerClass, $taxonomy->getRestControllerClass());
    }

    public function testSetCapabilities(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');
        $capabilities = [
            'manage_terms' => 'manage_genres',
            'edit_terms' => 'edit_genres',
            'delete_terms' => 'delete_genres',
            'assign_terms' => 'assign_genres',
        ];

        $taxonomy->setCapabilities($capabilities);

        $this->assertEquals($capabilities, $taxonomy->getCapabilities());
    }

    public function testSetDefaultTerm(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');
        $defaultTerm = 'uncategorized';

        $taxonomy->setDefaultTerm($defaultTerm);

        $this->assertEquals($defaultTerm, $taxonomy->getDefaultTerm());
    }

    public function testSetDefaultTermWithDetails(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');
        $defaultTerm = [
            'name' => 'Uncategorized',
            'slug' => 'uncategorized',
            'description' => 'Default term',
        ];

        $taxonomy->setDefaultTerm($defaultTerm);

        $this->assertEquals($defaultTerm, $taxonomy->getDefaultTerm());
    }

    public function testSetAdminCols(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');
        $adminCols = [
            'description' => [
                'title' => 'Description',
                'function' => function() {
                    return 'Description';
                }
            ]
        ];

        $taxonomy->setAdminCols($adminCols);

        $this->assertEquals($adminCols, $taxonomy->getAdminCols());
    }

    public function testSetQueryVar(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');
        $queryVar = 'genre';

        $taxonomy->setQueryVar($queryVar);

        $this->assertEquals($queryVar, $taxonomy->getQueryVar());
    }

    public function testSetRewrite(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');
        $rewrite = [
            'slug' => 'genres',
            'with_front' => false,
            'hierarchical' => true,
        ];

        $taxonomy->setRewrite($rewrite);

        $this->assertEquals($rewrite, $taxonomy->getRewrite());
    }

    public function testSetMetaBoxCb(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');
        $metaBoxCb = function($post, $box) {
            return 'Custom meta box';
        };

        $taxonomy->setMetaBoxCb($metaBoxCb);

        $this->assertEquals($metaBoxCb, $taxonomy->getMetaBoxCb());
    }

    public function testSetMetaBoxSanitizeCb(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');
        $metaBoxSanitizeCb = function($term_id, $tt_id) {
            return absint($term_id);
        };

        $taxonomy->setMetaBoxSanitizeCb($metaBoxSanitizeCb);

        $this->assertEquals($metaBoxSanitizeCb, $taxonomy->getMetaBoxSanitizeCb());
    }

    public function testSetUpdateCountCallback(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');
        $updateCountCallback = function($terms, $taxonomy) {
            return true;
        };

        $taxonomy->setUpdateCountCallback($updateCountCallback);

        $this->assertEquals($updateCountCallback, $taxonomy->getUpdateCountCallback());
    }

    public function testSetArgs(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');
        $args = [
            'orderby' => 'name',
            'hide_empty' => false,
        ];

        $taxonomy->setArgs($args);

        $this->assertEquals($args, $taxonomy->getArgs());
    }

    public function testSetRawArgs(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');
        $rawArgs = [
            'show_admin_column' => true,
            'show_tagcloud' => false,
            'show_in_quick_edit' => true,
            'meta_box_cb' => 'my_custom_meta_box',
        ];

        $taxonomy->setRawArgs($rawArgs);

        $this->assertEquals($rawArgs, $taxonomy->getRawArgs());
    }

    public function testToArray(): void
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');
        $taxonomy->setHierarchical(true)
            ->setShowInRest(true)
            ->setRestBase('genres')
            ->setRestControllerClass('WP_REST_Terms_Controller')
            ->setCapabilities([
                'manage_terms' => 'manage_genres',
                'edit_terms' => 'edit_genres',
                'delete_terms' => 'delete_genres',
                'assign_terms' => 'assign_genres',
            ])
            ->setDefaultTerm('uncategorized')
            ->setAdminCols([
                'description' => [
                    'title' => 'Description',
                    'function' => function() {
                        return 'Description';
                    }
                ]
            ])
            ->setQueryVar('genre')
            ->setRewrite([
                'slug' => 'genres',
                'with_front' => false,
                'hierarchical' => true,
            ])
            ->setMetaBoxCb(function($post, $box) {
                return 'Custom meta box';
            })
            ->setMetaBoxSanitizeCb(function($term_id, $tt_id) {
                return absint($term_id);
            })
            ->setUpdateCountCallback(function($terms, $taxonomy) {
                return true;
            })
            ->setArgs([
                'orderby' => 'name',
                'hide_empty' => false,
            ])
            ->setRawArgs([
                'show_admin_column' => true,
                'show_tagcloud' => false,
                'show_in_quick_edit' => true,
                'meta_box_cb' => 'my_custom_meta_box',
            ]);

        $array = $taxonomy->toArray();

        $this->assertEquals('genre', $array['slug']);
        $this->assertEquals('book', $array['object_type']);
        $this->assertEquals('Genre', $array['singular']);
        $this->assertEquals('Genres', $array['plural']);
        $this->assertTrue($array['hierarchical']);
        $this->assertTrue($array['public']);
        $this->assertTrue($array['show_ui']);
        $this->assertTrue($array['show_in_menu']);
        $this->assertTrue($array['show_in_nav_menus']);
        $this->assertFalse($array['show_tagcloud']);
        $this->assertTrue($array['show_in_quick_edit']);
        $this->assertTrue($array['show_admin_column']);
        $this->assertTrue($array['show_in_rest']);
        $this->assertEquals('genres', $array['rest_base']);
        $this->assertEquals('WP_REST_Terms_Controller', $array['rest_controller_class']);
        $this->assertEquals([
            'manage_terms' => 'manage_genres',
            'edit_terms' => 'edit_genres',
            'delete_terms' => 'delete_genres',
            'assign_terms' => 'assign_genres',
        ], $array['capabilities']);
        $this->assertEquals('uncategorized', $array['default_term']);
        $this->assertEquals([
            'description' => [
                'title' => 'Description',
                'function' => function() {
                    return 'Description';
                }
            ]
        ], $array['admin_cols']);
        $this->assertEquals('genre', $array['query_var']);
        $this->assertEquals([
            'slug' => 'genres',
            'with_front' => false,
            'hierarchical' => true,
        ], $array['rewrite']);
        $this->assertEquals('my_custom_meta_box', $array['meta_box_cb']);
        $this->assertIsCallable($array['meta_box_sanitize_cb']);
        $this->assertIsCallable($array['update_count_callback']);
        if (isset($array['args'])) {
            $this->assertEquals([
                'orderby' => 'name',
                'hide_empty' => false,
            ], $array['args']);
        } else {
            $this->assertNull($array['args'] ?? null);
        }
        $this->assertArrayHasKey('show_admin_column', $array);
        $this->assertArrayHasKey('show_tagcloud', $array);
        $this->assertArrayHasKey('show_in_quick_edit', $array);
        $this->assertArrayHasKey('meta_box_cb', $array);
        $this->assertEquals(true, $array['show_admin_column']);
        $this->assertEquals(false, $array['show_tagcloud']);
        $this->assertEquals(true, $array['show_in_quick_edit']);
        $this->assertEquals('my_custom_meta_box', $array['meta_box_cb']);
    }
}
