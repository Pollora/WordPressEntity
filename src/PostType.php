<?php

declare(strict_types=1);

namespace Pollora\Entity;

use Pollora\Entity\Traits\ArgumentTranslater;
use Pollora\Entity\Traits\Entity;

class PostType extends Entity
{
    /**
     * The entity name, used for registration.
     */
    protected string $entity = 'post-types';

    /**
     * Whether to exclude posts with this post type from front end search
     * results.
     *
     * Default is the opposite value of $public.
     *
     * @since 4.6.0
     *
     * @var bool
     */
    public $excludeFromSearch;

    /**
     * The position in the menu order the post type should appear.
     *
     * To work, $show_in_menu must be true. Default null (at the bottom).
     *
     * @since 4.6.0
     *
     * @var int
     */
    /**
     * The position in the menu order the post type should appear.
     *
     * To work, $show_in_menu must be true. Default null (at the bottom).
     *
     * @since 4.6.0
     *
     * @var int
     */
    public $menuPosition;

    /**
     * The URL or reference to the icon to be used for this menu.
     *
     * Pass a base64-encoded SVG using a data URI, which will be colored to match the color scheme.
     * This should begin with 'data:image/svg+xml;base64,'. Pass the name of a Dashicons helper class
     * to use a font icon, e.g. 'dashicons-chart-pie'. Pass 'none' to leave div.wp-menu-image empty
     * so an icon can be added via CSS.
     *
     * Defaults to use the posts icon.
     *
     * @since 4.6.0
     *
     * @var string
     */
    public $menuIcon;

    /**
     * Makes this post type available via the admin bar.
     *
     * Default is the value of $show_in_menu.
     *
     * @since 4.6.0
     *
     * @var bool
     */
    public $showInAdminBar;

    /**
     * The string to use to build the read, edit, and delete capabilities.
     *
     * May be passed as an array to allow for alternative plurals when using
     * this argument as a base to construct the capabilities, e.g.
     * array( 'story', 'stories' ). Default 'post'.
     *
     * @since 4.6.0
     *
     * @var string
     */
    public $capabilityType;

    /**
     * Whether to use the internal default meta capability handling.
     *
     * Default false.
     *
     * @since 4.6.0
     *
     * @var bool
     */
    public $mapMetaCap;

    /**
     * Provide a callback function that sets up the meta boxes for the edit form.
     *
     * Do `remove_meta_box()` and `add_meta_box()` calls in the callback. Default null.
     *
     * @since 4.6.0
     *
     * @var callable
     */
    public $registerMetaBoxCb;

    /**
     * An array of taxonomy identifiers that will be registered for the post type.
     *
     * Taxonomies can be registered later with `register_taxonomy()` or `register_taxonomy_for_object_type()`.
     *
     * Default empty array.
     *
     * @since 4.6.0
     *
     * @var string[]
     */
    public $taxonomies;

    /**
     * Whether there should be post type archives, or if a string, the archive slug to use.
     *
     * Will generate the proper rewrite rules if $rewrite is enabled. Default false.
     *
     * @since 4.6.0
     *
     * @var bool|string
     */
    public $hasArchive;

    /**
     * Whether to allow this post type to be exported.
     *
     * Default true.
     *
     * @since 4.6.0
     *
     * @var bool
     */
    public $canExport;

    /**
     * Whether to delete posts of this type when deleting a user.
     *
     * - If true, posts of this type belonging to the user will be moved to Trash when the user is deleted.
     * - If false, posts of this type belonging to the user will *not* be trashed or deleted.
     * - If not set (the default), posts are trashed if post type supports the 'author' feature.
     *   Otherwise posts are not trashed or deleted.
     *
     * Default null.
     *
     * @since 4.6.0
     *
     * @var bool
     */
    public $deleteWithUser;

    /**
     * The controller instance for this post type's REST API endpoints.
     *
     * Lazily computed. Should be accessed using {@see WP_Post_Type::get_rest_controller()}.
     *
     * @since 5.3.0
     *
     * @var \WP_REST_Controller
     */
    public $restController;

    /**
     * Array of blocks to use as the default initial state for an editor session.
     *
     * Each item should be an array containing block name and optional attributes.
     *
     * Default empty array.
     *
     * @link https://developer.wordpress.org/block-editor/developers/block-api/block-templates/
     * @since 5.0.0
     *
     * @var array[]
     */
    public $template;

    /**
     * Whether the block template should be locked if $template is set.
     *
     * - If set to 'all', the user is unable to insert new blocks, move existing blocks
     *   and delete blocks.
     * - If set to 'insert', the user is able to move existing blocks but is unable to insert
     *   new blocks and delete blocks.
     *
     * Default false.
     *
     * @link https://developer.wordpress.org/block-editor/developers/block-api/block-templates/
     * @since 5.0.0
     *
     * @var string|false
     */
    public $templateLock;

    /**
     * The features supported by the post type.
     *
     * @since 4.6.0
     *
     * @var array|bool
     */
    public $supports;

    /**
     * Associative array of admin screen filters to show for this post type.
     *
     * @var array<string,mixed>
     */
    public $adminFilters;

    /**
     * Associative array of query vars to override on this post type's archive.
     *
     * @var array<string,mixed>
     */
    public $archive;

    /**
     * Whether to show this post type on the 'Recently Published' section of the
     * admin dashboard.
     *
     * Default true.
     */
    public $dashboardActivity;

    /**
     * Placeholder text which appears in the title field for this post type.
     */
    public $enterTitleHere;

    /**
     * Text which replaces the 'Featured Image' phrase for this post type.
     */
    public $featuredImage;

    /**
     * Whether to show Quick Edit links for this post type.
     *
     * Default true.
     */
    public $quickEdit;

    /**
     * Whether to include this post type in the site's main feed.
     *
     * Default false.
     */
    public $showInFeed;

    /**
     * Associative array of query vars and their parameters for front end filtering.
     *
     * @var array<string,mixed>
     */
    public $siteFilters;

    /**
     * Associative array of query vars and their parameters for front end sorting.
     *
     * @var array<string,mixed>
     */
    public $siteSortables;

    /**
     * Get the exclude from search flag.
     *
     * @return bool|null Returns the value of excludeFromSearch flag. It will return a boolean value if the flag is set, otherwise null.
     */
    public function getExcludeFromSearch(): ?bool
    {
        return $this->excludeFromSearch;
    }

    /**
     * Marks the object as excluded from search.
     *
     * @return self Returns the current object instance to allow method chaining.
     */
    public function excludeFromSearch(): self
    {
        $this->excludeFromSearch = true;

        return $this;
    }

    /**
     * Set whether the posts should be excluded from search.
     *
     * @param  bool|null  $excludeFromSearch Determines if the item should be excluded from search. Set to null to unset.
     * @return self Returns the current object instance to allow method chaining.
     */
    public function setExcludeFromSearch(?bool $excludeFromSearch): self
    {
        $this->excludeFromSearch = $excludeFromSearch;

        return $this;
    }

    /**
     * Enable chronological ordering.
     *
     * @return self Returns the current object instance to allow method chaining.
     */
    public function chronological(): self
    {
        $this->hierarchical = false;

        return $this;
    }

    /**
     * Set whether the hierarchical property should be enabled or not.
     *
     * @param  bool  $hierarchical Whether the hierarchical property should be enabled or not.
     * @return self Returns the current object instance to allow method chaining.
     */
    public function setHierarchical(bool $hierarchical): self
    {
        $this->hierarchical = $hierarchical;

        return $this;
    }

    /**
     * Get the "show in admin bar" status.
     *
     * @return bool|null The "show in admin bar" status, or null if not set.
     */
    public function getShowInAdminBar(): ?bool
    {
        return $this->showInAdminBar;
    }

    /**
     * Set the flag to show the item in the admin bar.
     *
     * @return self Returns the current object instance to allow method chaining.
     */
    public function showInAdminBar(): self
    {
        $this->showInAdminBar = true;

        return $this;
    }

    /**
     * Set whether to show the object in the admin bar.
     *
     * @param  bool|null  $showInAdminBar Set to true to show the object in the admin bar, false to hide it, or null to inherit the value from the parent object.
     * @return self Returns the current object instance to allow method chaining.
     */
    public function setShowInAdminBar(?bool $showInAdminBar): self
    {
        $this->showInAdminBar = $showInAdminBar;

        return $this;
    }

    /**
     * Get the menu position.
     *
     * @return int|null The menu position if set, or null if not set.
     */
    public function getMenuPosition(): ?int
    {
        return $this->menuPosition;
    }

    /**
     * Set the menu position.
     *
     * @param  int|null  $menuPosition The menu position to set.
     * @return self Returns the current object instance to allow method chaining.
     */
    public function setMenuPosition(?int $menuPosition): self
    {
        $this->menuPosition = $menuPosition;

        return $this;
    }

    /**
     * Get the menu icon.
     *
     * @return string|null Returns the menu icon if set, or null if not set.
     */
    public function getMenuIcon(): ?string
    {
        return $this->menuIcon;
    }

    /**
     * Set the menu icon.
     *
     * @param  string|null  $menuIcon The menu icon to set.
     * @return self Returns the current object instance to allow method chaining.
     */
    public function setMenuIcon(?string $menuIcon): self
    {
        $this->menuIcon = $menuIcon;

        return $this;
    }

    /**
     * Get the capability type.
     *
     * @return string|null The capability type, or null if it has not been set.
     */
    public function getCapabilityType(): ?string
    {
        return $this->capabilityType;
    }

    /**
     * Set the capability type.
     *
     * @param  string  $capabilityType The capability type to set.
     * @return self Returns the current object instance to allow method chaining.
     */
    public function setCapabilityType(string $capabilityType): self
    {
        $this->capabilityType = $capabilityType;

        return $this;
    }

    /**
     * Checks if the current object has a map meta capability value set.
     *
     * @return bool|null Returns true if the map meta capability value is set, false if it is not set,
     *                  or null if the value has not been set at all.
     */
    public function isMapMetaCap(): ?bool
    {
        return $this->mapMetaCap;
    }

    /**
     * Maps meta capabilities.
     *
     * This method is used to enable meta capability mapping for the current object.
     * Meta capabilities are used to define whether a user has a certain capability
     * in relation to a specific object or context.
     *
     * @return $this Returns the current object to allow method chaining.
     */
    public function mapMetaCap(): self
    {
        $this->mapMetaCap = true;

        return $this;
    }

    /**
     * Set the value of mapMetaCap property.
     *
     * @param  bool  $mapMetaCap The boolean value indicating if the map capability should be mapped to meta capabilities.
     */
    public function setMapMetaCap(bool $mapMetaCap): self
    {
        $this->mapMetaCap = $mapMetaCap;

        return $this;
    }

    /**
     * Retrieves the callback function for registering a meta box.
     *
     * @return callable|null Returns the callback function for registering a meta box, or null if not set.
     */
    public function getRegisterMetaBoxCb(): ?callable
    {
        return $this->registerMetaBoxCb;
    }

    /**
     * Sets the callback function for registering a meta box.
     *
     * @param  callable|null  $registerMetaBoxCb The callback function for registering a meta box.
     * @return self Returns an instance of the object.
     */
    public function setRegisterMetaBoxCb(?callable $registerMetaBoxCb): self
    {
        $this->registerMetaBoxCb = $registerMetaBoxCb;

        return $this;
    }

    /**
     * Retrieves the taxonomies.
     *
     * This method returns the taxonomies stored in the current instance.
     *
     * @return array|null The taxonomies or null if not set.
     */
    public function getTaxonomies(): ?array
    {
        return $this->taxonomies;
    }

    /**
     * Set the taxonomies for this object.
     *
     * @param  array  $taxonomies An array of taxonomies to set.
     * @return self|null Returns itself after setting the taxonomies.
     */
    public function setTaxonomies(array $taxonomies): ?self
    {
        $this->taxonomies = $taxonomies;

        return $this;
    }

    /**
     * Get the "hasArchive" property of the object.
     *
     * @return bool|string|null The value of the "hasArchive" property.
     */
    public function getHasArchive(): bool|string|null
    {
        return $this->hasArchive;
    }

    /**
     * Set the archive status for the object.
     *
     * @param  bool|string  $hasArchive The archive status to be set. Defaults to true.
     */
    public function hasArchive(bool|string $hasArchive = true): self
    {
        $this->hasArchive = $hasArchive;

        return $this;
    }

    /**
     * Determines if the content can be exported.
     *
     * @return bool|null True if the content can be exported, false otherwise, or null if not set.
     */
    public function getCanExport(): ?bool
    {
        return $this->canExport;
    }

    /**
     * Sets the canExport property to true.
     *
     * @return self The current object instance.
     */
    public function canExport(): self
    {
        $this->canExport = true;

        return $this;
    }

    /**
     * Sets the flag indicating whether the content can be exported or not.
     *
     * @param  bool  $canExport The flag indicating whether the content can be exported.
     * @return self Returns the modified object.
     */
    public function setCanExport(bool $canExport): self
    {
        $this->canExport = $canExport;

        return $this;
    }

    /**
     * Retrieves the flag indicating whether the deletion should be performed
     * together with the associated user.
     *
     * @return bool|null True if the deletion should be performed with the user,
     *                  false if not, or null if the flag is not set.
     */
    public function getDeleteWithUser(): ?bool
    {
        return $this->deleteWithUser;
    }

    /**
     * Marks the item for deletion with the user.
     *
     * @return self Returns the current object instance.
     */
    public function deletedWithUser(): self
    {
        $this->deleteWithUser = true;

        return $this;
    }

    /**
     * Sets whether the deletion of the object should be performed with the user.
     *
     * @param  bool|null  $deleteWithUser Whether the deletion should be performed with the user.
     *                                  True if deletion should be performed with the user,
     *                                  false if not, and null if it should be determined
     *                                  based on system configuration.
     * @return self Returns an instance of the current object.
     */
    public function setDeleteWithUser(?bool $deleteWithUser): self
    {
        $this->deleteWithUser = $deleteWithUser;

        return $this;
    }

    /**
     * Retrieves the WP_REST_Controller associated with this object.
     *
     * @return \WP_REST_Controller|null The WP_REST_Controller object associated with this object, or null if no WP_REST_Controller is set.
     */
    public function getRestController(): ?\WP_REST_Controller
    {
        return $this->restController;
    }

    /**
     * Sets the REST controller.
     *
     * @param  \WP_REST_Controller  $restController The REST controller to set.
     * @return self Returns the updated instance of the object.
     */
    public function setRestController(\WP_REST_Controller $restController): self
    {
        $this->restController = $restController;

        return $this;
    }

    /**
     * Retrieves the template for the site.
     *
     * @return array|null The template for the site, or null if none is set.
     */
    public function getTemplate(): ?array
    {
        return $this->template;
    }

    /**
     * Sets the template for the object.
     *
     * @param  array  $template The template to set.
     * @return self Returns the object itself for method chaining.
     */
    public function setTemplate(array $template): self
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Retrieves the lock status of the template.
     *
     * @return bool|string|null The lock status of the template.
     *                          Returns true if the template is locked.
     *                          Returns false if the template is not locked.
     *                          Returns null if the lock status is unknown.
     */
    public function getTemplateLock(): bool|string|null
    {
        return $this->templateLock;
    }

    /**
     * Sets the template lock for the object.
     *
     * @param  bool|string  $templateLock The template lock value to set. This can be either a boolean or a string.
     * @return self Returns the instance of the object.
     */
    public function setTemplateLock(bool|string $templateLock): self
    {
        $this->templateLock = $templateLock;

        return $this;
    }

    /**
     * Retrieves the supports for the current object.
     *
     * @return bool|array|null The supports for the current object. This will either be a boolean value, an array,
     *                         or null if no supports are set.
     */
    public function getSupports(): bool|array|null
    {
        return $this->supports;
    }

    /**
     * Sets the support options for the site.
     *
     * @param  bool|array  $supports The support options, can be a boolean value or an array of options.
     * @return self The updated instance of the class.
     */
    public function supports(bool|array $supports): self
    {
        $this->supports = $supports;

        return $this;
    }

    /**
     * Retrieves the admin filters for the site.
     *
     * @return array|null The admin filters for the site, or null if none are set.
     */
    public function getAdminFilters(): ?array
    {
        return $this->adminFilters;
    }

    /**
     * Sets the admin filters for the site.
     *
     * @param  array  $adminFilters The admin filters to be set.
     */
    public function adminFilters(array $adminFilters): self
    {
        $this->adminFilters = $adminFilters;

        return $this;
    }

    /**
     * Retrieves the archive for the site.
     *
     * @return array|null The archive for the site, or null if none is set.
     */
    public function getArchive(): ?array
    {
        return $this->archive;
    }

    /**
     * Sets the archive for the site.
     *
     * @param  array  $archive The archive to set.
     * @return self The updated instance of the class.
     */
    public function setArchive(array $archive): self
    {
        $this->archive = $archive;

        return $this;
    }

    /**
     * Checks if the block editor is enabled for the site.
     *
     * @return bool|null True if the block editor is enabled, false if not, or null if not set.
     */
    public function isBlockEditor(): ?bool
    {
        return $this->showInRest;
    }

    /**
     * Enables the block editor for the site.
     *
     * @return self The updated instance of the class.
     */
    public function enableBlockEditor(): self
    {
        $this->showInRest = true;

        return $this;
    }

    /**
     * Sets the flag indicating whether the block editor is enabled or not.
     *
     * @param  bool  $blockEditor The flag indicating whether the block editor is enabled or not.
     * @return self The updated object.
     */
    public function setBlockEditor(bool $blockEditor): self
    {
        $this->showInRest = $blockEditor;

        return $this;
    }

    /**
     * Checks if the dashboard activity is enabled.
     *
     * @return bool|null Returns true if the dashboard activity is enabled, false if it is disabled,
     *                   or null if it is not set.
     */
    public function isDashboardActivity(): ?bool
    {
        return $this->dashboardActivity;
    }

    /**
     * Enables dashboard activity for the current user.
     *
     * @return self The current object with dashboard activity enabled.
     */
    public function enableDashboardActivity(): self
    {
        $this->dashboardActivity = true;

        return $this;
    }

    /**
     * Sets the dashboard activity flag.
     *
     * @param  bool  $dashboardActivity The new value of the dashboard activity flag.
     * @return self Returns the current instance of the class.
     */
    public function setDashboardActivity(bool $dashboardActivity): self
    {
        $this->dashboardActivity = $dashboardActivity;

        return $this;
    }

    /**
     * Retrieves the value of EnterTitleHere.
     *
     * @return string|null The value of EnterTitleHere, or null if it is not set.
     */
    public function getEnterTitleHere(): ?string
    {
        return $this->enterTitleHere;
    }

    /**
     * Sets the title placeholder for the form.
     *
     * @param  string  $enterTitleHere The title placeholder to be set.
     * @return self Returns the current instance of the class.
     */
    public function titlePlaceholder(string $enterTitleHere): self
    {
        $this->enterTitleHere = $enterTitleHere;

        return $this;
    }

    /**
     * Retrieves the featured image for the site.
     *
     * @return string|null The URL of the featured image, or null if none is set.
     */
    public function getFeaturedImage(): ?string
    {
        return $this->featuredImage;
    }

    /**
     * Sets the featured image for the site.
     *
     * @param  string  $featuredImage The URL or path to the featured image.
     * @return self The instance of the class.
     */
    public function setFeaturedImage(string $featuredImage): self
    {
        $this->featuredImage = $featuredImage;

        return $this;
    }

    /**
     * Checks whether quick editing is enabled.
     *
     * @return bool|null Returns true if quick editing is enabled, false if disabled, or null if not set.
     */
    public function isQuickEdit(): ?bool
    {
        return $this->quickEdit;
    }

    /**
     * Sets the quickEdit flag for the object.
     *
     * @param  bool  $quickEdit The quickEdit flag to set.
     * @return self The updated object with the quickEdit flag set.
     */
    public function setQuickEdit(bool $quickEdit): self
    {
        $this->quickEdit = $quickEdit;

        return $this;
    }

    /**
     * Enables quick edit mode.
     *
     * @return self The current object instance.
     */
    public function enableQuickEdit(): self
    {
        $this->quickEdit = true;

        return $this;
    }

    /**
     * Determines if the value of showInFeed is true or false.
     *
     * @return bool|null Returns the value of showInFeed property, which indicates whether the item is shown in the feed.
     */
    public function isShowInFeed(): ?bool
    {
        return $this->showInFeed;
    }

    /**
     * Sets the value for the "showInFeed" property.
     *
     * @param  bool  $showInFeed The value to set for the "showInFeed" property.
     */
    public function setShowInFeed(bool $showInFeed): self
    {
        $this->showInFeed = $showInFeed;

        return $this;
    }

    /**
     * Marks the item as to be shown in the feed.
     *
     * @return $this
     */
    public function showInFeed(): self
    {
        $this->showInFeed = true;

        return $this;
    }

    /**
     * Retrieves the site filters.
     *
     * @return array|null The site filters, if available; otherwise null.
     */
    public function getSiteFilters(): ?array
    {
        return $this->siteFilters;
    }

    /**
     * Set the site filters.
     *
     * @param  array  $siteFilters The array containing site filters.
     * @return self The current object with the updated site filters.
     */
    public function siteFilters(array $siteFilters): self
    {
        $this->siteFilters = $siteFilters;

        return $this;
    }

    /**
     * Retrieves the sortables for the site.
     *
     * @return array|null The sortables for the site, or null if none are set.
     */
    public function getSiteSortables(): ?array
    {
        return $this->siteSortables;
    }

    /**
     * Set the site sortables.
     *
     * @param  array  $siteSortables The array of site sortables.
     * @return self The current instance of the object.
     */
    public function siteSortables(array $siteSortables): self
    {
        $this->siteSortables = $siteSortables;

        return $this;
    }

    public function __construct(
        public string $slug,
        public ?string $singular = null,
        public ?string $plural = null
    ) {
    }

    /**
     * Create a new Post Type
     *
     * @param  string  $slug The slug to set.
     * @param  string|null  $singular (Optional) The singular label.
     * @param  string|null  $plural (Optional) The plural form of the label.
     * @return self Returns a new instance of the class.
     */
    public static function make(string $slug, string $singular = null, string $plural = null): self
    {
        $instance = new static($slug, $singular, $plural);
        $instance->init();
        return $instance;
    }
}
