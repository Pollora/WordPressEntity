<?php

declare(strict_types=1);

namespace Pollora\Entity\Domain\Models;

/**
 * Represents a post type in the domain.
 *
 * This is a pure domain entity with no WordPress dependencies.
 */
class PostType
{
    /**
     * The entity name, used for registration.
     */
    protected string $entity = 'post-types';

    /**
     * General properties
     */
    protected ?string $label = null;

    protected ?array $labels = null;

    protected ?string $description = null;

    protected ?bool $public = null;

    protected ?bool $publiclyQueryable = null;

    protected ?bool $hierarchical = null;

    protected bool|array|null $rewrite = null;

    protected ?bool $showUi = null;

    protected bool|string|null $showInMenu = null;

    protected ?bool $showInNavMenus = null;

    protected bool|string|null $queryVar = null;

    protected ?bool $showInRest = null;

    protected bool|string|null $restBase = null;

    protected bool|string|null $restNamespace = null;

    protected bool|string|null $restControllerClass = null;

    protected ?array $capabilities = null;

    protected ?bool $dashboardGlance = null;

    protected ?array $adminCols = null;

    protected array $names = [];

    /**
     * Post type specific properties
     */
    protected ?bool $excludeFromSearch = null;

    protected ?int $menuPosition = null;

    protected ?string $menuIcon = null;

    protected ?bool $showInAdminBar = null;

    protected ?string $capabilityType = null;

    protected ?bool $mapMetaCap = null;

    protected mixed $registerMetaBoxCb = null;

    protected ?array $taxonomies = null;

    protected bool|string|null $hasArchive = null;

    protected ?bool $canExport = null;

    protected ?bool $deleteWithUser = null;

    protected ?array $template = null;

    protected bool|string|null $templateLock = null;

    protected bool|array|null $supports = null;

    protected ?array $adminFilters = null;

    protected ?array $archive = null;

    protected ?bool $blockEditor = null;

    protected ?bool $dashboardActivity = null;

    protected ?string $enterTitleHere = null;

    protected ?string $featuredImage = null;

    protected ?bool $quickEdit = null;

    protected ?bool $showInFeed = null;

    protected ?array $siteFilters = null;

    protected ?array $siteSortables = null;

    /**
     * Raw arguments for the post type
     */
    protected ?array $rawArgs = null;

    /**
     * Constructor for creating a PostType entity.
     *
     * @param  string  $slug  The slug for the post type (required)
     * @param  string|null  $singular  The singular name (optional)
     * @param  string|null  $plural  The plural name (optional)
     */
    public function __construct(
        protected string $slug,
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
     * Factory method to create a new PostType instance.
     *
     * @param  string  $slug  The slug for the post type
     * @param  string|null  $singular  The singular name
     * @param  string|null  $plural  The plural name
     */
    public static function make(string $slug, ?string $singular = null, ?string $plural = null): self
    {
        return new self($slug, $singular, $plural);
    }

    /**
     * Gets the slug of the post type.
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Gets the singular name of the post type.
     */
    public function getSingular(): ?string
    {
        return $this->singular;
    }

    /**
     * Gets the plural name of the post type.
     */
    public function getPlural(): ?string
    {
        return $this->plural;
    }

    /**
     * Sets the singular name of the post type.
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
     * Sets the plural name of the post type.
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
     * Gets the labels for the post type.
     */
    public function getLabels(): ?array
    {
        return $this->labels;
    }

    /**
     * Sets the labels for the post type.
     */
    public function setLabels(array $labels): self
    {
        $this->labels = $labels;

        return $this;
    }

    /**
     * Gets the label for the post type.
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * Sets the label for the post type.
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Gets the names array for the post type.
     */
    public function getNames(): array
    {
        return $this->names;
    }

    /**
     * Sets the names array for the post type.
     */
    public function setNames(array $names): self
    {
        $this->names = $names;

        return $this;
    }

    /**
     * Gets the description of the post type.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Sets the description of the post type.
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Checks if the post type is public.
     */
    public function isPublic(): ?bool
    {
        return $this->public;
    }

    /**
     * Sets the post type as public.
     */
    public function public(): self
    {
        $this->public = true;

        return $this;
    }

    /**
     * Sets the post type as private.
     */
    public function private(): self
    {
        $this->public = false;

        return $this;
    }

    /**
     * Sets the public flag for the post type.
     */
    public function setPublic(bool $public): self
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Gets whether the post type should exclude from search.
     */
    public function getExcludeFromSearch(): ?bool
    {
        return $this->excludeFromSearch;
    }

    /**
     * Sets the post type to exclude from search.
     */
    public function excludeFromSearch(): self
    {
        $this->excludeFromSearch = true;

        return $this;
    }

    /**
     * Sets whether to exclude the post type from search.
     */
    public function setExcludeFromSearch(?bool $excludeFromSearch): self
    {
        $this->excludeFromSearch = $excludeFromSearch;

        return $this;
    }

    /**
     * Checks if the post type is hierarchical.
     */
    public function isHierarchical(): ?bool
    {
        return $this->hierarchical;
    }

    /**
     * Makes the post type hierarchical.
     */
    public function hierarchical(): self
    {
        $this->hierarchical = true;

        return $this;
    }

    /**
     * Sets the hierarchical state for the post type.
     */
    public function setHierarchical(bool $hierarchical): self
    {
        $this->hierarchical = $hierarchical;

        return $this;
    }

    /**
     * Gets the menu icon for the post type.
     */
    public function getMenuIcon(): ?string
    {
        return $this->menuIcon;
    }

    /**
     * Sets the menu icon for the post type.
     */
    public function setMenuIcon(string $menuIcon): self
    {
        $this->menuIcon = $menuIcon;

        return $this;
    }

    /**
     * Gets the capability type for the post type.
     */
    public function getCapabilityType(): ?string
    {
        return $this->capabilityType;
    }

    /**
     * Sets the capability type for the post type.
     */
    public function setCapabilityType(string $capabilityType): self
    {
        $this->capabilityType = $capabilityType;

        return $this;
    }

    /**
     * Gets the menu position for the post type.
     */
    public function getMenuPosition(): ?int
    {
        return $this->menuPosition;
    }

    /**
     * Sets the menu position for the post type.
     */
    public function setMenuPosition(int $menuPosition): self
    {
        $this->menuPosition = $menuPosition;

        return $this;
    }

    /**
     * Gets the taxonomies associated with the post type.
     */
    public function getTaxonomies(): ?array
    {
        return $this->taxonomies;
    }

    /**
     * Sets the taxonomies associated with the post type.
     */
    public function setTaxonomies(array $taxonomies): self
    {
        $this->taxonomies = $taxonomies;

        return $this;
    }

    /**
     * Gets the supports array for the post type.
     */
    public function getSupports(): bool|array|null
    {
        return $this->supports;
    }

    /**
     * Sets the supports array for the post type.
     */
    public function supports(array|bool $supports): self
    {
        $this->supports = $supports;

        return $this;
    }

    /**
     * Gets the rewrite rules for the post type.
     */
    public function getRewrite(): bool|array|null
    {
        return $this->rewrite;
    }

    /**
     * Sets the rewrite rules for the post type.
     */
    public function setRewrite(array|bool $rewrite): self
    {
        $this->rewrite = $rewrite;

        return $this;
    }

    /**
     * Gets the has archive setting for the post type.
     */
    public function getHasArchive(): bool|string|null
    {
        return $this->hasArchive;
    }

    /**
     * Sets the has archive setting for the post type.
     */
    public function hasArchive(bool|string $hasArchive): self
    {
        $this->hasArchive = $hasArchive;

        return $this;
    }

    /**
     * Convert the post type to an array.
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
     * Gets the show in admin bar setting.
     */
    public function getShowInAdminBar(): ?bool
    {
        return $this->showInAdminBar;
    }

    /**
     * Sets the post type to show in admin bar.
     */
    public function showInAdminBar(): self
    {
        $this->showInAdminBar = true;

        return $this;
    }

    /**
     * Sets whether to show the post type in admin bar.
     */
    public function setShowInAdminBar(?bool $showInAdminBar): self
    {
        $this->showInAdminBar = $showInAdminBar;

        return $this;
    }

    /**
     * Gets whether the post type maps meta capabilities.
     */
    public function isMapMetaCap(): ?bool
    {
        return $this->mapMetaCap;
    }

    /**
     * Sets the post type to map meta capabilities.
     */
    public function mapMetaCap(): self
    {
        $this->mapMetaCap = true;

        return $this;
    }

    /**
     * Sets whether the post type maps meta capabilities.
     */
    public function setMapMetaCap(bool $mapMetaCap): self
    {
        $this->mapMetaCap = $mapMetaCap;

        return $this;
    }

    /**
     * Gets the register meta box callback.
     */
    public function getRegisterMetaBoxCb(): mixed
    {
        return $this->registerMetaBoxCb;
    }

    /**
     * Sets the register meta box callback.
     */
    public function setRegisterMetaBoxCb(?callable $registerMetaBoxCb): self
    {
        $this->registerMetaBoxCb = $registerMetaBoxCb;

        return $this;
    }

    /**
     * Gets whether the post type can be exported.
     */
    public function getCanExport(): ?bool
    {
        return $this->canExport;
    }

    /**
     * Sets the post type to be exportable.
     */
    public function canExport(): self
    {
        $this->canExport = true;

        return $this;
    }

    /**
     * Sets whether the post type can be exported.
     */
    public function setCanExport(bool $canExport): self
    {
        $this->canExport = $canExport;

        return $this;
    }

    /**
     * Gets whether the post type should be deleted with user.
     */
    public function getDeleteWithUser(): ?bool
    {
        return $this->deleteWithUser;
    }

    /**
     * Sets the post type to be deleted with user.
     */
    public function deletedWithUser(): self
    {
        $this->deleteWithUser = true;

        return $this;
    }

    /**
     * Sets whether the post type should be deleted with user.
     */
    public function setDeleteWithUser(?bool $deleteWithUser): self
    {
        $this->deleteWithUser = $deleteWithUser;

        return $this;
    }

    /**
     * Gets the template for the post type.
     */
    public function getTemplate(): ?array
    {
        return $this->template;
    }

    /**
     * Sets the template for the post type.
     */
    public function setTemplate(array $template): self
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Gets the template lock for the post type.
     */
    public function getTemplateLock(): bool|string|null
    {
        return $this->templateLock;
    }

    /**
     * Sets the template lock for the post type.
     */
    public function setTemplateLock(bool|string $templateLock): self
    {
        $this->templateLock = $templateLock;

        return $this;
    }

    /**
     * Checks if the post type uses the block editor.
     */
    public function isBlockEditor(): ?bool
    {
        return $this->showInRest;
    }

    /**
     * Enables the block editor for the post type.
     */
    public function enableBlockEditor(): self
    {
        $this->showInRest = true;

        return $this;
    }

    /**
     * Sets whether the post type uses the block editor.
     */
    public function setBlockEditor(bool $blockEditor): self
    {
        $this->showInRest = $blockEditor;

        return $this;
    }

    /**
     * Gets whether the post type shows in dashboard activity.
     */
    public function isDashboardActivity(): ?bool
    {
        return $this->dashboardActivity;
    }

    /**
     * Enables dashboard activity for the post type.
     */
    public function enableDashboardActivity(): self
    {
        $this->dashboardActivity = true;

        return $this;
    }

    /**
     * Sets whether the post type shows in dashboard activity.
     */
    public function setDashboardActivity(bool $dashboardActivity): self
    {
        $this->dashboardActivity = $dashboardActivity;

        return $this;
    }

    /**
     * Gets the enter title here text for the post type.
     */
    public function getEnterTitleHere(): ?string
    {
        return $this->enterTitleHere;
    }

    /**
     * Sets the title placeholder for the post type.
     */
    public function titlePlaceholder(string $enterTitleHere): self
    {
        $this->enterTitleHere = $enterTitleHere;

        return $this;
    }

    /**
     * Gets the featured image text for the post type.
     */
    public function getFeaturedImage(): ?string
    {
        return $this->featuredImage;
    }

    /**
     * Sets the featured image text for the post type.
     */
    public function setFeaturedImage(string $featuredImage): self
    {
        $this->featuredImage = $featuredImage;

        return $this;
    }

    /**
     * Gets whether the post type supports quick edit.
     */
    public function isQuickEdit(): ?bool
    {
        return $this->quickEdit;
    }

    /**
     * Sets the post type to enable quick edit.
     */
    public function enableQuickEdit(): self
    {
        $this->quickEdit = true;

        return $this;
    }

    /**
     * Sets whether the post type supports quick edit.
     */
    public function setQuickEdit(bool $quickEdit): self
    {
        $this->quickEdit = $quickEdit;

        return $this;
    }

    /**
     * Gets whether the post type shows in feed.
     */
    public function isShowInFeed(): ?bool
    {
        return $this->showInFeed;
    }

    /**
     * Sets the post type to show in feed.
     */
    public function showInFeed(): self
    {
        $this->showInFeed = true;

        return $this;
    }

    /**
     * Sets whether the post type shows in feed.
     */
    public function setShowInFeed(bool $showInFeed): self
    {
        $this->showInFeed = $showInFeed;

        return $this;
    }

    /**
     * Gets the site filters for the post type.
     */
    public function getSiteFilters(): ?array
    {
        return $this->siteFilters;
    }

    /**
     * Sets the site filters for the post type.
     */
    public function siteFilters(array $siteFilters): self
    {
        $this->siteFilters = $siteFilters;

        return $this;
    }

    /**
     * Gets the site sortables for the post type.
     */
    public function getSiteSortables(): ?array
    {
        return $this->siteSortables;
    }

    /**
     * Sets the site sortables for the post type.
     */
    public function siteSortables(array $siteSortables): self
    {
        $this->siteSortables = $siteSortables;

        return $this;
    }

    /**
     * Sets the post type to be chronological.
     */
    public function chronological(): self
    {
        $this->hierarchical = false;

        return $this;
    }

    /**
     * Gets the admin filters for the post type.
     */
    public function getAdminFilters(): ?array
    {
        return $this->adminFilters;
    }

    /**
     * Sets the admin filters for the post type.
     */
    public function adminFilters(array $adminFilters): self
    {
        $this->adminFilters = $adminFilters;

        return $this;
    }

    /**
     * Gets the archive settings for the post type.
     */
    public function getArchive(): ?array
    {
        return $this->archive;
    }

    /**
     * Sets the archive settings for the post type.
     */
    public function setArchive(array $archive): self
    {
        $this->archive = $archive;

        return $this;
    }

    /**
     * Sets raw arguments for the post type.
     * This allows direct setting of WordPress register_post_type arguments.
     *
     * @param  array  $args  The raw arguments to set
     */
    public function rawArgs(array $args): self
    {
        $this->rawArgs = $args;

        return $this;
    }

    /**
     * Gets the raw arguments for the post type.
     */
    public function getRawArgs(): ?array
    {
        return $this->rawArgs;
    }

    /**
     * Gets the query var for the post type.
     */
    public function getQueryVar(): bool|string|null
    {
        return $this->queryVar;
    }

    /**
     * Sets the query var for the post type.
     */
    public function setQueryVar(bool|string|null $queryVar): self
    {
        $this->queryVar = $queryVar;

        return $this;
    }

    /**
     * Gets whether the post type shows in menu.
     */
    public function getShowInMenu(): bool|string|null
    {
        return $this->showInMenu;
    }

    /**
     * Sets whether the post type shows in menu.
     */
    public function setShowInMenu(bool|string|null $showInMenu): self
    {
        $this->showInMenu = $showInMenu;

        return $this;
    }

    /**
     * Gets whether the post type shows in nav menus.
     */
    public function getShowInNavMenus(): ?bool
    {
        return $this->showInNavMenus;
    }

    /**
     * Sets whether the post type shows in nav menus.
     */
    public function setShowInNavMenus(?bool $showInNavMenus): self
    {
        $this->showInNavMenus = $showInNavMenus;

        return $this;
    }

    /**
     * Gets whether the post type shows in REST API.
     */
    public function getShowInRest(): ?bool
    {
        return $this->showInRest;
    }

    /**
     * Sets whether the post type shows in REST API.
     */
    public function setShowInRest(?bool $showInRest): self
    {
        $this->showInRest = $showInRest;

        return $this;
    }

    /**
     * Gets the REST base for the post type.
     */
    public function getRestBase(): bool|string|null
    {
        return $this->restBase;
    }

    /**
     * Sets the REST base for the post type.
     */
    public function setRestBase(bool|string|null $restBase): self
    {
        $this->restBase = $restBase;

        return $this;
    }

    /**
     * Gets the REST namespace for the post type.
     */
    public function getRestNamespace(): bool|string|null
    {
        return $this->restNamespace;
    }

    /**
     * Sets the REST namespace for the post type.
     */
    public function setRestNamespace(bool|string|null $restNamespace): self
    {
        $this->restNamespace = $restNamespace;

        return $this;
    }

    /**
     * Gets the REST controller class for the post type.
     */
    public function getRestControllerClass(): bool|string|null
    {
        return $this->restControllerClass;
    }

    /**
     * Sets the REST controller class for the post type.
     */
    public function setRestControllerClass(bool|string|null $restControllerClass): self
    {
        $this->restControllerClass = $restControllerClass;

        return $this;
    }

    /**
     * Gets the capabilities for the post type.
     */
    public function getCapabilities(): ?array
    {
        return $this->capabilities;
    }

    /**
     * Sets the capabilities for the post type.
     */
    public function setCapabilities(?array $capabilities): self
    {
        $this->capabilities = $capabilities;

        return $this;
    }

    /**
     * Gets whether the post type shows in dashboard glance.
     */
    public function getDashboardGlance(): ?bool
    {
        return $this->dashboardGlance;
    }

    /**
     * Sets whether the post type shows in dashboard glance.
     */
    public function setDashboardGlance(?bool $dashboardGlance): self
    {
        $this->dashboardGlance = $dashboardGlance;

        return $this;
    }

    /**
     * Gets the admin columns for the post type.
     */
    public function getAdminCols(): ?array
    {
        return $this->adminCols;
    }

    /**
     * Sets the admin columns for the post type.
     */
    public function setAdminCols(?array $adminCols): self
    {
        $this->adminCols = $adminCols;

        return $this;
    }
}
