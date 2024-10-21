<?php

declare(strict_types=1);

namespace Pollora\Entity;

use Pollora\Entity\Traits\Entity;

class Taxonomy extends Entity
{
    /**
     * The entity name, used for registration.
     *
     * @var string
     */
    protected $entity = 'taxonomies';

    /**
     * Whether to list the taxonomy in the tag cloud widget controls.
     *
     * @since 4.7.0
     *
     * @var bool
     */
    public $showTagcloud;

    /**
     * Whether to show the taxonomy in the quick/bulk edit panel.
     *
     * @since 4.7.0
     *
     * @var bool
     */
    public $showInQuickEdit;

    /**
     * Whether to display a column for the taxonomy on its post type listing screens.
     *
     * @since 4.7.0
     *
     * @var bool
     */
    public $showAdminColumn;

    /**
     * The callback function for the meta box display.
     *
     * @since 4.7.0
     *
     * @var bool|callable
     */
    public $metaBoxCb;

    /**
     * The callback function for sanitizing taxonomy data saved from a meta box.
     *
     * @since 5.1.0
     *
     * @var callable
     */
    public $metaBoxSanitizeCb;

    /**
     * Function that will be called when the count is updated.
     *
     * @since 4.7.0
     *
     * @var callable
     */
    public $updateCountCallback;

    /**
     * The default term name for this taxonomy. If you pass an array you have
     * to set 'name' and optionally 'slug' and 'description'.
     *
     * @since 5.5.0
     *
     * @var array|string
     */
    public $defaultTerm;

    /**
     * Whether terms in this taxonomy should be sorted in the order they are provided to `wp_set_object_terms()`.
     *
     * Use this in combination with `'orderby' => 'term_order'` when fetching terms.
     *
     * @since 2.5.0
     *
     * @var bool|null
     */
    public $sort;

    /**
     * Array of arguments to automatically use inside `wp_get_object_terms()` for this taxonomy.
     *
     * @since 2.6.0
     *
     * @var array|null
     */
    public $args;

    /**
     * This allows you to override WordPress' default behaviour if necessary.
     *
     * Default false if you're using a custom meta box (see the `$meta_box` argument), default true otherwise.
     */
    public $checkedOntop;

    /**
     * This parameter isn't feature complete. All it does currently is set the meta box
     * to the 'radio' meta box, thus meaning any given post can only have one term
     * associated with it for that taxonomy.
     *
     * 'exclusive' isn't really the right name for this, as terms aren't exclusive to a
     * post, but rather each post can exclusively have only one term. It's not feature
     * complete because you can edit a post in Quick Edit and give it more than one term
     * from the taxonomy.
     */
    public $exclusive;

    /**
     * All this does currently is disable hierarchy in the taxonomy's rewrite rules.
     *
     * Default false.
     */
    public $allowHierarchy;

    /**
     * Determines whether the tag cloud should be displayed or not.
     *
     * @return bool|null Returns true if the tag cloud should be displayed, false if not, and null if not set.
     */
    public function isShowTagcloud(): ?bool
    {
        return $this->showTagcloud;
    }

    /**
     * Sets the property showTagcloud to true and returns the Taxonomy object.
     *
     * @return Taxonomy The updated Taxonomy object.
     */
    public function showTagcloud(): Taxonomy
    {
        $this->showTagcloud = true;

        return $this;
    }

    /**
     * Sets whether to show the tagcloud.
     *
     * @param  bool  $showTagcloud Whether to show the tagcloud.
     * @return Taxonomy The updated Taxonomy object.
     */
    public function setShowTagcloud(bool $showTagcloud): Taxonomy
    {
        $this->showTagcloud = $showTagcloud;

        return $this;
    }

    /**
     * Checks if the object should be shown in quick edit.
     *
     * @return bool|null True if the object should be shown in quick edit, false if it should not be shown,
     *                   or null if it is not defined.
     */
    public function isShowInQuickEdit(): ?bool
    {
        return $this->showInQuickEdit;
    }

    /**
     * Sets the showInQuickEdit property to true.
     *
     * @return Taxonomy The updated Taxonomy object.
     */
    public function showInQuickEdit(): Taxonomy
    {
        $this->showInQuickEdit = true;

        return $this;
    }

    /**
     * Set the value of showInQuickEdit property.
     *
     * @param  bool  $showInQuickEdit The new value for the showInQuickEdit property.
     */
    public function setShowInQuickEdit(bool $showInQuickEdit): Taxonomy
    {
        $this->showInQuickEdit = $showInQuickEdit;

        return $this;
    }

    /**
     * Checks whether the admin column should be shown or not.
     *
     * @return bool|null Returns true if the admin column should be shown, false if it should not be shown,
     *                   or null if the value is not set.
     */
    public function isShowAdminColumn(): ?bool
    {
        return $this->showAdminColumn;
    }

    /**
     * Sets the showAdminColumn property to true.
     *
     * @return Taxonomy The updated Taxonomy object.
     */
    public function showAdminColumn(): Taxonomy
    {
        $this->showAdminColumn = true;

        return $this;
    }

    /**
     * Sets whether or not to show the admin column for the taxonomy.
     *
     * @param  bool  $showAdminColumn Whether or not to show the admin column.
     * @return Taxonomy The Taxonomy object.
     */
    public function setShowAdminColumn(bool $showAdminColumn): Taxonomy
    {
        $this->showAdminColumn = $showAdminColumn;

        return $this;
    }

    /**
     * Retrieves the metabox callback function.
     *
     * @return callable|bool|null The metabox callback function, or null if it does not exist.
     */
    public function getMetaBoxCb(): callable|bool|null
    {
        return $this->metaBoxCb;
    }

    /**
     * Sets the callback function for the meta box.
     *
     * @param  callable|bool|null  $metaBoxCb The callback function for the meta box. Can be a callable, boolean, or null.
     * @return Taxonomy The updated Taxonomy object.
     */
    public function setMetaBoxCb(callable|bool|null $metaBoxCb): Taxonomy
    {
        $this->metaBoxCb = $metaBoxCb;

        return $this;
    }

    /**
     * Retrieves the meta box sanitize callback.
     *
     * @return callable|null The sanitize callback, or null if it does not exist.
     */
    public function getMetaBoxSanitizeCb(): ?callable
    {
        return $this->metaBoxSanitizeCb;
    }

    /**
     * Sets the meta box sanitize callback function.
     *
     * @param  callable|null  $metaBoxSanitizeCb The meta box sanitize callback function, or null if none.
     * @return Taxonomy The Taxonomy object.
     */
    public function setMetaBoxSanitizeCb(?callable $metaBoxSanitizeCb): Taxonomy
    {
        $this->metaBoxSanitizeCb = $metaBoxSanitizeCb;

        return $this;
    }

    /**
     * Retrieves the update count callback.
     *
     * @return callable|null The update count callback if set, null otherwise.
     */
    public function getUpdateCountCallback(): ?callable
    {
        return $this->updateCountCallback;
    }

    /**
     * Sets the callback function for updating the count.
     *
     * @param  callable  $updateCountCallback The callback function to be set.
     * @return Taxonomy Returns the current instance of the Taxonomy class.
     */
    public function setUpdateCountCallback(callable $updateCountCallback): Taxonomy
    {
        $this->updateCountCallback = $updateCountCallback;

        return $this;
    }

    /**
     * Retrieves the default term value.
     *
     * @return array|string|null The default term value. If a default term is set, it will be returned as an array,
     *                          otherwise it can be null or a string.
     */
    public function getDefaultTerm(): array|string|null
    {
        return $this->defaultTerm;
    }

    /**
     * Sets the default term for the taxonomy.
     *
     * @param  array|string  $defaultTerm The default term for the taxonomy. Can be either an array or a string.
     * @return Taxonomy  The current instance of the Taxonomy object.
     */
    public function setDefaultTerm(array|string $defaultTerm): Taxonomy
    {
        $this->defaultTerm = $defaultTerm;

        return $this;
    }

    /**
     * Returns the value of the `sort` property.
     *
     * @return ?bool The value of the `sort` property.
     */
    public function getSort(): ?bool
    {
        return $this->sort;
    }

    /**
     * Set the sort flag to true for the Taxonomy object.
     *
     * @return Taxonomy Returns the updated Taxonomy object.
     */
    public function sort(): Taxonomy
    {
        $this->sort = true;

        return $this;
    }

    /**
     * Sets the sorting option for the Taxonomy.
     *
     * @param  bool|null  $sort The sorting option for the Taxonomy. Pass true to enable sorting, false to disable sorting,
     *                        or null to use the default sorting option.
     * @return Taxonomy Returns the Taxonomy object for method chaining.
     */
    public function setSort(?bool $sort): Taxonomy
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get the arguments for the method.
     *
     * @return array|null The arguments for the method.
     */
    public function getArgs(): ?array
    {
        return $this->args;
    }

    /**
     * Set the arguments for the taxonomy.
     *
     * @param  array|null  $args The arguments for the taxonomy.
     * @return Taxonomy Returns the updated Taxonomy object.
     */
    public function setArgs(?array $args): Taxonomy
    {
        $this->args = $args;

        return $this;
    }

    /**
     * Check if the Taxonomy is on top.
     *
     * @return bool|null Returns the value indicating if the Taxonomy is on top or not.
     */
    public function isCheckedOntop(): ?bool
    {
        return $this->checkedOntop;
    }

    /**
     * Set the "checkedOntop" flag for the taxonomy.
     *
     * @param  bool  $checkedOntop The value to set for the "checkedOntop" flag.
     * @return Taxonomy Returns an instance of the Taxonomy class.
     */
    public function checkedOntop(): Taxonomy
    {
        $this->checkedOntop = true;

        return $this;
    }

    /**
     * Sets the checkedOntop flag for the Taxonomy object.
     *
     * @param  bool  $checkedOntop The flag indicating whether the Taxonomy should be checked on top or not.
     * @return Taxonomy Returns the updated Taxonomy object.
     */
    public function setCheckedOntop(bool $checkedOntop): Taxonomy
    {
        $this->checkedOntop = $checkedOntop;

        return $this;
    }

    /**
     * Returns the value of the "exclusive" variable.
     *
     * @return bool|null The value of the "exclusive" variable.
     */
    public function isExclusive(): ?bool
    {
        return $this->exclusive;
    }

    /**
     * Set the exclusive flag for the taxonomy.
     *
     * @param  bool  $exclusive The value of the exclusive flag.
     * @return Taxonomy The updated Taxonomy instance.
     */
    public function exclusive(): Taxonomy
    {
        $this->exclusive = true;

        return $this;
    }

    /**
     * Sets the exclusive flag.
     *
     * @param  bool  $exclusive The exclusive flag value.
     * @return Taxonomy The Taxonomy instance.
     */
    public function setExclusive(bool $exclusive): Taxonomy
    {
        $this->exclusive = $exclusive;

        return $this;
    }

    /**
     * Determines whether or not the taxonomy is allowed to have a hierarchy.
     *
     * @return bool|null Returns the value of the allowHierarchy property, which indicates whether the taxonomy is allowed to have a hierarchy. If the value is not set, null is returned.
     */
    public function isAllowHierarchy(): ?bool
    {
        return $this->allowHierarchy;
    }

    /**
     * Allows for hierarchy in taxonomy.
     *
     * @return Taxonomy The updated Taxonomy object.
     */
    public function allowHierarchy(): Taxonomy
    {
        $this->allowHierarchy = true;

        return $this;
    }

    /**
     * Sets whether the taxonomy allows hierarchical terms or not.
     *
     * @param  bool  $allowHierarchy The value indicating whether hierarchical terms are allowed.
     * @return Taxonomy The updated Taxonomy object.
     */
    public function setAllowHierarchy(bool $allowHierarchy): Taxonomy
    {
        $this->allowHierarchy = $allowHierarchy;

        return $this;
    }

    public function __construct(
        public string $slug,
        public string|array $objectType,
        public ?string $singular = null,
        public ?string $plural = null
    ) {
        $this->init();
    }

    /**
     * Create a new Taxonomy
     *e
     *
     * @param  string  $slug The slug to set.
     * @param  string|array  $objectType The post type(s) to be associated.
     * @param  string|null  $singular (Optional) The singular label.
     * @param  string|null  $plural (Optional) The plural form of the label.
     * @return self Returns a new instance of the class.
     */
    public static function make(string $slug, string|array $objectType, string $singular = null, string $plural = null): self
    {
        return new static($slug, $objectType, $singular , $plural);
    }
}
