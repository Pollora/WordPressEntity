<?php

declare(strict_types=1);

namespace Pollora\Entity\Domain\Models;

/**
 * Represents a taxonomy in the domain.
 *
 * This is a pure domain entity with no WordPress dependencies.
 */
class Taxonomy
{
    /**
     * The entity name, used for registration.
     */
    protected string $entity = 'taxonomies';

    /**
     * General properties
     */
    protected ?string $label = null;

    protected ?array $labels = null;

    protected ?string $description = null;

    protected bool $public = true;

    protected ?bool $publiclyQueryable = null;

    protected bool $hierarchical = false;

    protected bool|array|null $rewrite = null;

    protected bool $showUi = true;

    protected bool|string|null $showInMenu = true;

    protected bool $showInNavMenus = true;

    protected bool|string|null $queryVar = null;

    protected ?bool $showInRest = false;

    protected bool|string|null $restBase = null;

    protected bool|string|null $restNamespace = null;

    protected bool|string|null $restControllerClass = null;

    protected ?array $capabilities = null;

    protected ?bool $dashboardGlance = null;

    protected ?array $adminCols = null;

    protected array $names = [];

    /**
     * Taxonomy specific properties
     */
    protected bool $showTagcloud = true;

    protected bool $showInQuickEdit = true;

    protected bool $showAdminColumn = true;

    protected mixed $metaBoxCb = null;

    protected mixed $metaBoxSanitizeCb = null;

    protected mixed $updateCountCallback = null;

    protected string|array|null $defaultTerm = null;

    protected ?bool $sort = null;

    protected ?array $args = null;

    protected ?bool $checkedOntop = null;

    protected ?bool $exclusive = null;

    protected ?bool $allowHierarchy = null;

    /**
     * Raw arguments for the taxonomy
     */
    protected ?array $rawArgs = null;

    /**
     * Constructor for creating a Taxonomy entity.
     *
     * @param  string  $slug  The slug for the taxonomy (required)
     * @param  string|array  $objectType  The post type(s) to associate this taxonomy with
     * @param  string|null  $singular  The singular name (optional)
     * @param  string|null  $plural  The plural name (optional)
     */
    public function __construct(
        protected string $slug,
        protected string|array $objectType,
        protected ?string $singular = null,
        protected ?string $plural = null
    ) {
        $this->names = [
            'slug' => $slug,
            'singular' => $singular ?: $slug,
            'plural' => $plural ?: ($singular ? $singular.'s' : $slug.'s'),
        ];
    }

    /**
     * Factory method to create a new Taxonomy instance.
     *
     * @param  string  $slug  The slug for the taxonomy
     * @param  string|array  $objectType  The post type(s) to associate this taxonomy with
     * @param  string|null  $singular  The singular name
     * @param  string|null  $plural  The plural name
     */
    public static function make(string $slug, string|array $objectType, ?string $singular = null, ?string $plural = null): self
    {
        return new self($slug, $objectType, $singular, $plural);
    }

    /**
     * Gets the slug of the taxonomy.
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Gets the object type(s) for the taxonomy.
     */
    public function getObjectType(): string|array
    {
        return $this->objectType;
    }

    /**
     * Gets the singular name of the taxonomy.
     */
    public function getSingular(): ?string
    {
        return $this->singular;
    }

    /**
     * Gets the plural name of the taxonomy.
     */
    public function getPlural(): ?string
    {
        return $this->plural;
    }

    /**
     * Sets the singular name of the taxonomy.
     *
     * @param  string  $singular  The singular name
     */
    public function setSingular(string $singular): self
    {
        $this->singular = $singular;
        $this->names['singular'] = $singular;

        return $this;
    }

    /**
     * Sets the plural name of the taxonomy.
     *
     * @param  string  $plural  The plural name
     */
    public function setPlural(string $plural): self
    {
        $this->plural = $plural;
        $this->names['plural'] = $plural;

        return $this;
    }

    /**
     * Gets the entity type.
     */
    public function getEntity(): string
    {
        return $this->entity;
    }

    /**
     * Gets the labels for the taxonomy.
     */
    public function getLabels(): ?array
    {
        return $this->labels;
    }

    /**
     * Sets the labels for the taxonomy.
     */
    public function setLabels(array $labels): self
    {
        $this->labels = $labels;

        return $this;
    }

    /**
     * Gets the label for the taxonomy.
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * Sets the label for the taxonomy.
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Gets the names array for the taxonomy.
     */
    public function getNames(): array
    {
        return $this->names;
    }

    /**
     * Sets the names array for the taxonomy.
     */
    public function setNames(array $names): self
    {
        $this->names = $names;

        return $this;
    }

    /**
     * Determines whether the tag cloud should be displayed or not.
     *
     * @return bool Returns true if the tag cloud should be displayed, false if not.
     */
    public function isShowTagcloud(): bool
    {
        return $this->showTagcloud;
    }

    /**
     * Sets the property showTagcloud to true and returns the Taxonomy object.
     *
     * @return self The updated Taxonomy object.
     */
    public function showTagcloud(): self
    {
        $this->showTagcloud = true;

        return $this;
    }

    /**
     * Sets whether to show the tagcloud.
     *
     * @param  bool  $showTagcloud  Whether to show the tagcloud.
     * @return self The updated Taxonomy object.
     */
    public function setShowTagcloud(bool $showTagcloud): self
    {
        $this->showTagcloud = $showTagcloud;

        return $this;
    }

    /**
     * Checks if the object should be shown in quick edit.
     *
     * @return bool True if the object should be shown in quick edit, false if it should not be shown.
     */
    public function isShowInQuickEdit(): bool
    {
        return $this->showInQuickEdit;
    }

    /**
     * Sets the showInQuickEdit property to true.
     *
     * @return self The updated Taxonomy object.
     */
    public function showInQuickEdit(): self
    {
        $this->showInQuickEdit = true;

        return $this;
    }

    /**
     * Set the value of showInQuickEdit property.
     *
     * @param  bool  $showInQuickEdit  The new value for the showInQuickEdit property.
     */
    public function setShowInQuickEdit(bool $showInQuickEdit): self
    {
        $this->showInQuickEdit = $showInQuickEdit;

        return $this;
    }

    /**
     * Convert the taxonomy to an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $formatter = new \Pollora\Entity\Infrastructure\Services\ArgumentFormatterService();
        $exclude = ['entity', 'rawArgs', 'names'];
        $formatted = $formatter->format($this, $exclude, null);
        if ($this->rawArgs !== null) {
            return array_merge($formatted, $this->rawArgs);
        }
        return $formatted;
    }

    /**
     * Checks whether the admin column should be shown or not.
     *
     * @return bool Returns true if the admin column should be shown, false if it should not be shown.
     */
    public function isShowAdminColumn(): bool
    {
        return $this->showAdminColumn;
    }

    /**
     * Sets the showAdminColumn property to true.
     *
     * @return self The updated Taxonomy object.
     */
    public function showAdminColumn(): self
    {
        $this->showAdminColumn = true;

        return $this;
    }

    /**
     * Sets whether or not to show the admin column for the taxonomy.
     *
     * @param  bool  $showAdminColumn  Whether or not to show the admin column.
     * @return self The Taxonomy object.
     */
    public function setShowAdminColumn(bool $showAdminColumn): self
    {
        $this->showAdminColumn = $showAdminColumn;

        return $this;
    }

    /**
     * Retrieves the metabox callback function.
     *
     * @return mixed The metabox callback function, or null if it does not exist.
     */
    public function getMetaBoxCb(): mixed
    {
        return $this->metaBoxCb;
    }

    /**
     * Sets the callback function for the meta box.
     *
     * @param  mixed  $metaBoxCb  The callback function for the meta box. Can be a callable, boolean, or null.
     * @return self The updated Taxonomy object.
     */
    public function setMetaBoxCb(mixed $metaBoxCb): self
    {
        $this->metaBoxCb = $metaBoxCb;

        return $this;
    }

    /**
     * Retrieves the meta box sanitize callback.
     *
     * @return mixed The sanitize callback, or null if it does not exist.
     */
    public function getMetaBoxSanitizeCb(): mixed
    {
        return $this->metaBoxSanitizeCb;
    }

    /**
     * Sets the meta box sanitize callback function.
     *
     * @param  mixed  $metaBoxSanitizeCb  The meta box sanitize callback function, or null if none.
     * @return self The Taxonomy object.
     */
    public function setMetaBoxSanitizeCb(mixed $metaBoxSanitizeCb): self
    {
        $this->metaBoxSanitizeCb = $metaBoxSanitizeCb;

        return $this;
    }

    /**
     * Retrieves the update count callback.
     *
     * @return mixed The update count callback if set, null otherwise.
     */
    public function getUpdateCountCallback(): mixed
    {
        return $this->updateCountCallback;
    }

    /**
     * Sets the callback function for updating the count.
     *
     * @param  mixed  $updateCountCallback  The callback function to be set.
     * @return self Returns the current instance of the Taxonomy class.
     */
    public function setUpdateCountCallback(mixed $updateCountCallback): self
    {
        $this->updateCountCallback = $updateCountCallback;

        return $this;
    }

    /**
     * Retrieves the default term value.
     *
     * @return array|string|null The default term value. If a default term is set, it will be returned as an array,
     *                           otherwise it can be null or a string.
     */
    public function getDefaultTerm(): string|array|null
    {
        return $this->defaultTerm;
    }

    /**
     * Sets the default term for the taxonomy.
     *
     * @param  array|string  $defaultTerm  The default term for the taxonomy. Can be either an array or a string.
     * @return self The current instance of the Taxonomy object.
     */
    public function setDefaultTerm(string|array|null $defaultTerm): self
    {
        $this->defaultTerm = $defaultTerm;

        return $this;
    }

    /**
     * Returns the value of the `sort` property.
     *
     * @return bool|null The value of the `sort` property.
     */
    public function getSort(): ?bool
    {
        return $this->sort;
    }

    /**
     * Set the sort flag to true for the Taxonomy object.
     *
     * @return self Returns the updated Taxonomy object.
     */
    public function sort(): self
    {
        $this->sort = true;

        return $this;
    }

    /**
     * Sets the sorting option for the Taxonomy.
     *
     * @param  bool|null  $sort  The sorting option for the Taxonomy. Pass true to enable sorting, false to disable sorting,
     *                           or null to use the default sorting option.
     * @return self Returns the Taxonomy object for method chaining.
     */
    public function setSort(?bool $sort): self
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
     * @param  array|null  $args  The arguments for the taxonomy.
     * @return self Returns the updated Taxonomy object.
     */
    public function setArgs(?array $args): self
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
     * @return self Returns an instance of the Taxonomy class.
     */
    public function checkedOntop(): self
    {
        $this->checkedOntop = true;

        return $this;
    }

    /**
     * Sets the checkedOntop flag for the Taxonomy object.
     *
     * @param  bool  $checkedOntop  The flag indicating whether the Taxonomy should be checked on top or not.
     * @return self Returns the updated Taxonomy object.
     */
    public function setCheckedOntop(bool $checkedOntop): self
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
     * @return self The updated Taxonomy instance.
     */
    public function exclusive(): self
    {
        $this->exclusive = true;

        return $this;
    }

    /**
     * Sets the exclusive flag.
     *
     * @param  bool  $exclusive  The exclusive flag value.
     * @return self The Taxonomy instance.
     */
    public function setExclusive(bool $exclusive): self
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
     * @return self The updated Taxonomy object.
     */
    public function allowHierarchy(): self
    {
        $this->allowHierarchy = true;

        return $this;
    }

    /**
     * Sets whether the taxonomy allows hierarchical terms or not.
     *
     * @param  bool  $allowHierarchy  The value indicating whether hierarchical terms are allowed.
     * @return self The updated Taxonomy object.
     */
    public function setAllowHierarchy(bool $allowHierarchy): self
    {
        $this->allowHierarchy = $allowHierarchy;

        return $this;
    }

    /**
     * Checks if the taxonomy is public.
     */
    public function isPublic(): bool
    {
        return $this->public;
    }

    /**
     * Sets the taxonomy as public.
     */
    public function public(): self
    {
        $this->public = true;

        return $this;
    }

    /**
     * Sets the taxonomy as private.
     */
    public function private(): self
    {
        $this->public = false;

        return $this;
    }

    /**
     * Sets the public flag for the taxonomy.
     */
    public function setPublic(bool $public): self
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Checks if the taxonomy is publicly queryable.
     */
    public function getPubliclyQueryable(): ?bool
    {
        return $this->publiclyQueryable;
    }

    /**
     * Sets the taxonomy as publicly queryable.
     */
    public function publiclyQueryable(): self
    {
        $this->publiclyQueryable = true;

        return $this;
    }

    /**
     * Sets whether the taxonomy is publicly queryable.
     */
    public function setPubliclyQueryable(?bool $publiclyQueryable): self
    {
        $this->publiclyQueryable = $publiclyQueryable;

        return $this;
    }

    /**
     * Checks if the taxonomy is hierarchical.
     */
    public function isHierarchical(): bool
    {
        return $this->hierarchical;
    }

    /**
     * Sets the taxonomy as hierarchical.
     */
    public function hierarchical(): self
    {
        $this->hierarchical = true;

        return $this;
    }

    /**
     * Sets whether the taxonomy is hierarchical.
     */
    public function setHierarchical(bool $hierarchical): self
    {
        $this->hierarchical = $hierarchical;

        return $this;
    }

    /**
     * Gets the rewrite setting for the taxonomy.
     */
    public function getRewrite(): ?array
    {
        return $this->rewrite;
    }

    /**
     * Sets the rewrite setting for the taxonomy.
     */
    public function setRewrite(bool|array $rewrite): self
    {
        $this->rewrite = $rewrite;

        return $this;
    }

    /**
     * Gets whether the taxonomy shows in UI.
     */
    public function isShowUi(): bool
    {
        return $this->showUi;
    }

    /**
     * Sets the taxonomy to show in UI.
     */
    public function showUi(): self
    {
        $this->showUi = true;

        return $this;
    }

    /**
     * Sets whether the taxonomy shows in UI.
     */
    public function setShowUi(bool $showUi): self
    {
        $this->showUi = $showUi;

        return $this;
    }

    /**
     * Checks if the taxonomy is shown in menu.
     */
    public function isShowInMenu(): bool|string|null
    {
        return $this->showInMenu;
    }

    /**
     * Sets the taxonomy to be shown in menu.
     */
    public function showInMenu(): self
    {
        $this->showInMenu = true;

        return $this;
    }

    /**
     * Sets whether the taxonomy is shown in menu.
     */
    public function setShowInMenu(bool|string|null $showInMenu): self
    {
        $this->showInMenu = $showInMenu;

        return $this;
    }

    /**
     * Gets whether the taxonomy is shown in nav menus.
     */
    public function isShowInNavMenus(): bool
    {
        return $this->showInNavMenus;
    }

    /**
     * Sets whether the taxonomy is shown in nav menus.
     */
    public function setShowInNavMenus(bool $showInNavMenus): self
    {
        $this->showInNavMenus = $showInNavMenus;

        return $this;
    }

    /**
     * Gets the query var for the taxonomy.
     */
    public function getQueryVar(): string|bool|null
    {
        return $this->queryVar;
    }

    /**
     * Sets the query var for the taxonomy.
     */
    public function setQueryVar(string|bool|null $queryVar): self
    {
        $this->queryVar = $queryVar;

        return $this;
    }

    /**
     * Gets whether the taxonomy is shown in REST API.
     */
    public function isShowInRest(): bool
    {
        return $this->showInRest;
    }

    /**
     * Sets the taxonomy to be shown in REST API.
     */
    public function showInRest(): self
    {
        $this->showInRest = true;

        return $this;
    }

    /**
     * Sets whether the taxonomy is shown in REST API.
     */
    public function setShowInRest(bool $showInRest): self
    {
        $this->showInRest = $showInRest;

        return $this;
    }

    /**
     * Gets the REST base for the taxonomy.
     */
    public function getRestBase(): ?string
    {
        return $this->restBase;
    }

    /**
     * Sets the REST base for the taxonomy.
     */
    public function setRestBase(?string $restBase): self
    {
        $this->restBase = $restBase;

        return $this;
    }

    /**
     * Gets the REST namespace for the taxonomy.
     */
    public function getRestNamespace(): ?string
    {
        return $this->restNamespace;
    }

    /**
     * Sets the REST namespace for the taxonomy.
     */
    public function setRestNamespace(?string $restNamespace): self
    {
        $this->restNamespace = $restNamespace;

        return $this;
    }

    /**
     * Gets the REST controller class for the taxonomy.
     */
    public function getRestControllerClass(): ?string
    {
        return $this->restControllerClass;
    }

    /**
     * Sets the REST controller class for the taxonomy.
     */
    public function setRestControllerClass(?string $restControllerClass): self
    {
        $this->restControllerClass = $restControllerClass;

        return $this;
    }

    /**
     * Gets the capabilities for the taxonomy.
     */
    public function getCapabilities(): ?array
    {
        return $this->capabilities;
    }

    /**
     * Sets the capabilities for the taxonomy.
     */
    public function setCapabilities(array $capabilities): self
    {
        $this->capabilities = $capabilities;

        return $this;
    }

    /**
     * Checks if the taxonomy shows in dashboard glance.
     */
    public function isDashboardGlance(): ?bool
    {
        return $this->dashboardGlance;
    }

    /**
     * Enables dashboard glance for the taxonomy.
     */
    public function enableDashboardGlance(): self
    {
        $this->dashboardGlance = true;

        return $this;
    }

    /**
     * Sets whether the taxonomy shows in dashboard glance.
     */
    public function setDashboardGlance(bool $dashboardGlance): self
    {
        $this->dashboardGlance = $dashboardGlance;

        return $this;
    }

    /**
     * Gets the admin columns for the taxonomy.
     */
    public function getAdminCols(): ?array
    {
        return $this->adminCols;
    }

    /**
     * Sets the admin columns for the taxonomy.
     */
    public function setAdminCols(array $adminCols): self
    {
        $this->adminCols = $adminCols;

        return $this;
    }

    /**
     * Sets raw arguments for the taxonomy.
     * This allows direct setting of WordPress register_taxonomy arguments.
     *
     * @param  array  $args  The raw arguments to set
     */
    public function setRawArgs(array $args): self
    {
        $this->rawArgs = $args;

        return $this;
    }

    /**
     * Gets the raw arguments for the taxonomy.
     */
    public function getRawArgs(): ?array
    {
        return $this->rawArgs;
    }

    /**
     * Gets the description of the taxonomy.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Sets the description of the taxonomy.
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
