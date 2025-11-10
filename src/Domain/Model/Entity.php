<?php

declare(strict_types=1);

namespace Pollora\Entity\Domain\Model;

use Pollora\WordPressArgs\ArgumentHelper;

/**
 * The Entity class is an abstract model that provides common functionality
 * for WordPress entities like post types and taxonomies.
 *
 * This class is part of the Domain layer in the hexagonal architecture.
 */
abstract class Entity
{
    use ArgumentHelper;

    /**
     * The priority of the post type or taxonomy declaration
     *
     * @var init
     */
    public int $priority = 5;

    /**
     * Name of the post type or taxonomy shown in the menu. Usually plural.
     *
     * @var string
     */
    public $label;

    /**
     * Labels array for this post type or taxonomy.
     *
     * @var array
     */
    public $labels;

    /**
     * A short descriptive summary of what the post type or taxonomy is.
     *
     * @var string
     */
    public $description;

    /**
     * Whether a post type or taxonomy is intended for use publicly either via the admin interface or by front-end users.
     *
     * While the default settings of $exclude_from_search, $publicly_queryable, $show_ui, and $show_in_nav_menus
     * are inherited from public, each does not rely on this relationship and controls a very specific intention.
     *
     * @var bool
     */
    public $public;

    /**
     * Whether queries can be performed on the front end for the post type as part of `parse_request()` for post types or whether a taxonomy is intended for use publicly either via the admin interface or by front-end users
     *
     * @var bool
     */
    public $publiclyQueryable;

    /**
     * Whether the post type or taxonomy is hierarchical.
     *
     * @var bool
     */
    public $hierarchical;

    /**
     * Rewrites information for this post type or taxonomy.
     *
     * @var array|false
     */
    public $rewrite;

    /**
     * Whether to generate and allow a UI for managing this post type or taxonomy in the admin.
     *
     * Default is the value of $public.
     *
     * @var bool
     */
    public $showUi;

    /**
     * Where to show the post type or taxonomy in the admin menu.
     *
     * @var bool|string
     */
    public $showInMenu;

    /**
     * Makes this post type or taxonomy available for selection in navigation menus.
     *
     * Default is the value $public.
     *
     * @var bool
     */
    public $showInNavMenus;

    /**
     * Sets the query_var key for this post type or taxonomy.
     *
     * For post types, defaults to $post_type key. If false, a post type cannot be loaded at `?{query_var}={post_slug}`.
     * If specified as a string, the query `?{query_var_string}={post_slug}` will be valid.
     * For taxonomy, sets the query var key for this taxonomy. Default $taxonomy key.
     * If false, a taxonomy cannot be loaded at `?{query_var}={term_slug}`. If a string, the query `?{query_var}={term_slug}` will be valid.
     *
     * @var string|bool
     */
    public $queryVar;

    /**
     * Whether this post type or taxonomy should appear in the REST API.
     *
     * Default false. If true, standard endpoints will be registered with
     * respect to $rest_base and $rest_controller_class.
     *
     * @var bool
     */
    public $showInRest;

    /**
     * The base path for this REST API endpoints.
     *
     * @var string|bool
     */
    public $restBase;

    /**
     * The namespace for this REST API endpoints.
     *
     * @var string|bool
     */
    public $restNamespace;

    /**
     * The controller for this REST API endpoints.
     *
     * Custom controllers must extend WP_REST_Controller.
     *
     * @var string|bool
     */
    public $restControllerClass;

    /**
     * Post type or Taxonomy capabilities.
     *
     * @var array
     */
    public $capabilities;

    /**
     * Whether to show this post type or taxonomy on the 'At a Glance' section of the admin dashboard.
     */
    public $dashboardGlance;

    /**
     * Associative array of admin screen columns to show for this post type or taxonomy.
     *
     * @var array<string,mixed>
     */
    public $adminCols;

    /**
     * Names of the post type or taxonomy.
     *
     * @var array
     */
    public $names;

    /**
     * The entity name, used for registration.
     */
    protected string $entity = '';

    /**
     * Retrieves the label for the entity.
     *
     * @return int|null The declaration priority of the entity
     */
    public function getPriority(): ?int
    {
        return $this->priority;
    }

    /**
     * Sets the priority for the entity declaration.
     *
     * @param  int  $priority  The priority to set for the entity declaration
     * @return self Returns the instance of the class for method chaining.
     */
    public function priority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Retrieves the label for the entity.
     *
     * @return string|null Returns the label for the entity as a string.
     *                     If the label is set, the method will return the label string.
     *                     If the label is not set, the method will return null.
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * Sets the label for the entity.
     *
     * @param  string  $label  The label to set for the entity.
     * @return self Returns the instance of the class for method chaining.
     */
    public function label(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Sets the label for the entity.
     *
     * @deprecated Use label() instead
     * @param  string  $label  The label to set for the entity.
     * @return self Returns the instance of the class for method chaining.
     */
    public function setLabel(string $label): self
    {
        return $this->label($label);
    }

    /**
     * Retrieves the labels associated with the entity.
     *
     * @return array|null Returns an object containing the labels associated with the entity.
     *                    If labels are available, an array is returned with the label properties.
     *                    If labels are not available, null is returned.
     */
    public function getLabels(): ?array
    {
        return $this->labels;
    }

    /**
     * Sets the labels for the entity.
     *
     * @param  array  $labels  The labels array containing the labels for the entity.
     * @return self Returns an instance of the class.
     */
    public function labels(array $labels): self
    {
        $this->labels = $labels;

        return $this;
    }

    /**
     * Sets the labels for the entity.
     *
     * @deprecated Use labels() instead
     * @param  array  $labels  The labels array containing the labels for the entity.
     * @return self Returns an instance of the class.
     */
    public function setLabels(array $labels): self
    {
        return $this->labels($labels);
    }

    /**
     * Retrieves the description for the entity.
     *
     * @return string|null Returns the description for the entity.
     *                     If the value is null, no description is available.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Sets the description of the entity.
     *
     * @param  string  $description  The description of the entity.
     * @return self Returns an instance of the class with the updated description.
     */
    public function description(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Sets the description of the entity.
     *
     * @deprecated Use description() instead
     * @param  string  $description  The description of the entity.
     * @return self Returns an instance of the class with the updated description.
     */
    public function setDescription(string $description): self
    {
        return $this->description($description);
    }

    /**
     * Checks if the entity is public.
     *
     * @return bool|null Returns a boolean indicating if the entity is public.
     *                   If the value is true, the entity is public.
     *                   If the value is false, the entity is not public.
     *                   If the value is null, the entity's visibility is not defined and may require further processing.
     */
    public function isPublic(): ?bool
    {
        return $this->public;
    }

    /**
     * Set the entity as public.
     *
     * @return self Returns an instance of the current object with the public property set to true.
     */
    public function public(): self
    {
        $this->public = true;

        return $this;
    }

    /**
     * Sets the entity as private.
     *
     * @return self Returns the current instance of the class.
     */
    public function private(): self
    {
        $this->public = false;

        return $this;
    }

    /**
     * Sets whether the entity should be public or not.
     *
     * @param  bool  $public  The boolean indicating if the entity should be public or not.
     * @return self Returns the modified instance of the object.
     */
    public function withPublic(bool $public): self
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Sets whether the entity should be public or not.
     *
     * @deprecated Use withPublic() instead
     * @param  bool  $public  The boolean indicating if the entity should be public or not.
     * @return self Returns the modified instance of the object.
     */
    public function setPublic(bool $public): self
    {
        return $this->withPublic($public);
    }

    /**
     * Checks if the entity is publicly queryable.
     *
     * @return bool|null Returns a boolean indicating if the entity is publicly queryable.
     *                   If the value is true, the entity is publicly queryable.
     *                   If the value is false, the entity is not publicly queryable.
     *                   If the value is null, the value is not defined and may require further processing.
     */
    public function getPubliclyQueryable(): ?bool
    {
        return $this->publiclyQueryable;
    }

    /**
     * Sets the object to be publicly queryable.
     *
     * @return self Returns an instance of the current class.
     */
    public function publiclyQueryable(): self
    {
        $this->publiclyQueryable = true;

        return $this;
    }

    /**
     * Make this entity not publicly queryable.
     *
     * @return self Returns an instance of the current class.
     */
    public function notPubliclyQueryable(): self
    {
        $this->publiclyQueryable = false;

        return $this;
    }

    /**
     * Sets whether the entity can be publicly queried.
     *
     * @param  bool|null  $publiclyQueryable  The value indicating whether the entity can be publicly queried.
     * @return self Returns an instance of the current object.
     */
    public function withPubliclyQueryable(?bool $publiclyQueryable): self
    {
        $this->publiclyQueryable = $publiclyQueryable;

        return $this;
    }

    /**
     * Sets whether the entity can be publicly queried.
     *
     * @deprecated Use withPubliclyQueryable() instead
     * @param  bool|null  $publiclyQueryable  The value indicating whether the entity can be publicly queried.
     * @return self Returns an instance of the current object.
     */
    public function setPubliclyQueryable(?bool $publiclyQueryable): self
    {
        return $this->withPubliclyQueryable($publiclyQueryable);
    }

    /**
     * Check if the entity is hierarchical or not.
     *
     * @return bool|null Returns the hierarchical status of the capability. If the capability is
     *                   hierarchical (true), returns true. If the capability is not hierarchical (false), returns
     *                   false. If the hierarchical status is unknown, returns null.
     */
    public function isHierarchical(): ?bool
    {
        return $this->hierarchical;
    }

    /**
     * Enable hierarchical mode for entity.
     *
     * @return self Returns the current object instance to allow method chaining.
     */
    public function hierarchical(): self
    {
        $this->hierarchical = true;

        return $this;
    }

    /**
     * Disable hierarchical mode for entity.
     *
     * @return self Returns the current object instance to allow method chaining.
     */
    public function nonHierarchical(): self
    {
        $this->hierarchical = false;

        return $this;
    }

    /**
     * Sets whether the entity is hierarchical.
     *
     * @param  bool  $hierarchical  Whether the entity is hierarchical.
     * @return self Returns the current object instance to allow method chaining.
     */
    public function withHierarchical(bool $hierarchical): self
    {
        $this->hierarchical = $hierarchical;

        return $this;
    }

    /**
     * Sets whether the entity is hierarchical.
     *
     * @deprecated Use withHierarchical() instead
     * @param  bool  $hierarchical  Whether the entity is hierarchical.
     * @return self Returns the current object instance to allow method chaining.
     */
    public function setHierarchical(bool $hierarchical): self
    {
        return $this->withHierarchical($hierarchical);
    }

    /**
     * Gets the value of the showUi property.
     *
     * @return bool|null Returns a boolean indicating if the UI should be shown for this entity.
     *                   If the value is true, the UI should be shown.
     *                   If the value is false, the UI should not be shown.
     *                   If the value is null, the decision is not defined and may require further processing.
     */
    public function getShowUi(): ?bool
    {
        return $this->showUi;
    }

    /**
     * Sets the flag to show the UI for the entity.
     *
     * @return self Returns the updated instance of the class.
     */
    public function showUi(): self
    {
        $this->showUi = true;

        return $this;
    }

    /**
     * Hide the UI for this entity.
     *
     * @return self Returns the updated instance of the class.
     */
    public function hideUi(): self
    {
        $this->showUi = false;

        return $this;
    }

    /**
     * Sets whether the UI should be displayed for the entity.
     *
     * @param  bool|null  $showUi  The value indicating if the UI should be displayed.
     *                             - If the value is true, the UI should be displayed.
     *                             - If the value is false, the UI should not be displayed.
     *                             - If the value is null, the decision is not defined and may require further processing.
     * @return self The updated instance of the class.
     */
    public function withShowUi(?bool $showUi): self
    {
        $this->showUi = $showUi;

        return $this;
    }

    /**
     * Sets whether the UI should be displayed for the entity.
     *
     * @deprecated Use withShowUi() instead
     * @param  bool|null  $showUi  The value indicating if the UI should be displayed.
     *                             - If the value is true, the UI should be displayed.
     *                             - If the value is false, the UI should not be displayed.
     *                             - If the value is null, the decision is not defined and may require further processing.
     * @return self The updated instance of the class.
     */
    public function setShowUi(?bool $showUi): self
    {
        return $this->withShowUi($showUi);
    }

    /**
     * Checks if the entity should be displayed in the menu.
     *
     * @return bool|string|null Returns a boolean indicating if the entity should be displayed in the menu.
     *                          If the value is true, the entity should be displayed.
     *                          If the value is false, the entity should not be displayed.
     *                          If the value is null, the decision is not defined and may require further processing.
     */
    public function isShowInMenu(): bool|string|null
    {
        return $this->showInMenu;
    }

    /**
     * Sets the property "showInMenu" to true.
     *
     * @return $this
     */
    public function showInMenu()
    {
        $this->showInMenu = true;

        return $this;
    }

    /**
     * Hide this entity from the menu.
     *
     * @return self Returns the instance of the class.
     */
    public function hideFromMenu(): self
    {
        $this->showInMenu = false;

        return $this;
    }

    /**
     * Set the value for the showInMenu property.
     *
     * @param  bool|string  $showInMenu  The value to set for the showInMenu property.
     * @return self Returns the instance of the class.
     */
    public function withShowInMenu(bool|string $showInMenu): self
    {
        $this->showInMenu = $showInMenu;

        return $this;
    }

    /**
     * Set the value for the showInMenu property.
     *
     * @deprecated Use withShowInMenu() instead
     * @param  bool|string  $showInMenu  The value to set for the showInMenu property.
     * @return self Returns the instance of the class.
     */
    public function setShowInMenu(bool|string $showInMenu): self
    {
        $this->showInMenu = $showInMenu;

        return $this;
    }

    /**
     * Retrieves the value of the showInNavMenus property.
     *
     * @return bool|null The value of the showInNavMenus property.
     */
    public function getShowInNavMenus(): ?bool
    {
        return $this->showInNavMenus;
    }

    /**
     * Show this entity in navigation menus.
     *
     * @return self Returns the modified instance of the object.
     */
    public function showInNavMenus(): self
    {
        $this->showInNavMenus = true;

        return $this;
    }

    /**
     * Hide this entity from navigation menus.
     *
     * @return self Returns the modified instance of the object.
     */
    public function hideFromNavMenus(): self
    {
        $this->showInNavMenus = false;

        return $this;
    }

    /**
     * Sets whether the entity should be displayed in navigation menus.
     *
     * @param  bool|null  $showInNavMenus  Whether the entity should be displayed in navigation menus.
     *                                     Set to true if the entity should be displayed, false if it should not be displayed,
     *                                     or null if the entity's visibility in navigation menus should not be modified.
     * @return self Returns the modified instance of the object.
     */
    public function withShowInNavMenus(?bool $showInNavMenus): self
    {
        $this->showInNavMenus = $showInNavMenus;

        return $this;
    }

    /**
     * Sets whether the entity should be displayed in navigation menus.
     *
     * @deprecated Use withShowInNavMenus() instead
     * @param  bool|null  $showInNavMenus  Whether the entity should be displayed in navigation menus.
     *                                     Set to true if the entity should be displayed, false if it should not be displayed,
     *                                     or null if the entity's visibility in navigation menus should not be modified.
     * @return self Returns the modified instance of the object.
     */
    public function setShowInNavMenus(?bool $showInNavMenus): self
    {
        return $this->withShowInNavMenus($showInNavMenus);
    }

    /**
     * Retrieves the value of the queryVar property.
     *
     * @return bool|string|null The value of the queryVar property.
     */
    public function getQueryVar(): bool|string|null
    {
        return $this->queryVar;
    }

    /**
     * Sets the value of the queryVar property.
     *
     * @param  bool|string  $queryVar  The new value for the queryVar property.
     * @return self The instance of the object.
     */
    public function queryVar(bool|string $queryVar): self
    {
        $this->queryVar = $queryVar;

        return $this;
    }

    /**
     * Sets the value of the queryVar property.
     *
     * @deprecated Use withQueryVar() instead
     * @param  bool|string  $queryVar  The new value for the queryVar property.
     * @return self The instance of the object.
     */
    public function withQueryVar(bool|string $queryVar): self
    {
        return $this->queryVar($queryVar);
    }

    /**
     * Sets the value of the queryVar property.
     *
     * @deprecated Use queryVar() instead
     * @param  bool|string  $queryVar  The new value for the queryVar property.
     * @return self The instance of the object.
     */
    public function setQueryVar(bool|string $queryVar): self
    {
        return $this->queryVar($queryVar);
    }

    /**
     * Retrieves the value of the rewrite property.
     *
     * @return bool|array|null The value of the rewrite property.
     */
    public function getRewrite(): bool|array|null
    {
        return $this->rewrite;
    }

    /**
     * Sets the value of the rewrite property.
     *
     * @param  bool|array  $rewrite  The new value for the rewrite property.
     * @return self Returns an instance of the current object.
     */
    public function rewrite(bool|array $rewrite): self
    {
        $this->rewrite = $rewrite;

        return $this;
    }

    /**
     * Sets the value of the rewrite property.
     *
     * @deprecated Use withRewrite() instead
     * @param  bool|array  $rewrite  The new value for the rewrite property.
     * @return self Returns an instance of the current object.
     */
    public function withRewrite(bool|array $rewrite): self
    {
        return $this->rewrite($rewrite);
    }

    /**
     * Sets the value of the rewrite property.
     *
     * @deprecated Use rewrite() instead
     * @param  bool|array  $rewrite  The new value for the rewrite property.
     * @return self Returns an instance of the current object.
     */
    public function setRewrite(bool|array $rewrite): self
    {
        return $this->rewrite($rewrite);
    }

    /**
     * Retrieves the value of the showInRest property.
     *
     * @return bool|null The value of the showInRest property.
     */
    public function getShowInRest(): ?bool
    {
        return $this->showInRest;
    }

    /**
     * Marks the object as eligible to be shown in REST API responses.
     *
     * @return self The modified object.
     */
    public function showInRest(): self
    {
        $this->showInRest = true;

        return $this;
    }

    /**
     * Hide the object from REST API responses.
     *
     * @return self The modified object.
     */
    public function hideFromRest(): self
    {
        $this->showInRest = false;

        return $this;
    }

    /**
     * Sets the value of the showInRest property.
     *
     * @param  bool  $showInRest  The new value for the showInRest property.
     * @return self The current object with the updated showInRest property.
     */
    public function withShowInRest(bool $showInRest): self
    {
        $this->showInRest = $showInRest;

        return $this;
    }

    /**
     * Sets the value of the showInRest property.
     *
     * @deprecated Use withShowInRest() instead
     * @param  bool  $showInRest  The new value for the showInRest property.
     * @return self The current object with the updated showInRest property.
     */
    public function setShowInRest(bool $showInRest): self
    {
        return $this->withShowInRest($showInRest);
    }

    /**
     * Returns the rest base for the current instance.
     *
     * @return bool|string|null The rest base, or boolean false if not set.
     */
    public function getRestBase(): bool|string|null
    {
        return $this->restBase;
    }

    /**
     * Sets the value of the restBase property.
     *
     * @param  bool|string  $restBase  The value to set for the restBase property.
     * @return self This instance of the object.
     */
    public function restBase(bool|string $restBase): self
    {
        $this->restBase = $restBase;

        return $this;
    }

    /**
     * Sets the value of the restBase property.
     *
     * @deprecated Use withRestBase() instead
     * @param  bool|string  $restBase  The value to set for the restBase property.
     * @return self This instance of the object.
     */
    public function withRestBase(bool|string $restBase): self
    {
        return $this->restBase($restBase);
    }

    /**
     * Sets the value of the restBase property.
     *
     * @deprecated Use restBase() instead
     * @param  bool|string  $restBase  The value to set for the restBase property.
     * @return self This instance of the object.
     */
    public function setRestBase(bool|string $restBase): self
    {
        return $this->restBase($restBase);
    }

    /**
     * Retrieves the value of the restNamespace property.
     *
     * @return bool|string|null The value of the restNamespace property.
     */
    public function getRestNamespace(): bool|string|null
    {
        return $this->restNamespace;
    }

    /**
     * Sets the value of the restNamespace property.
     *
     * @param  bool|string  $restNamespace  The value to set for the restNamespace property.
     * @return self This method returns the current instance of the class.
     */
    public function restNamespace(bool|string $restNamespace): self
    {
        $this->restNamespace = $restNamespace;

        return $this;
    }

    /**
     * Sets the value of the restNamespace property.
     *
     * @deprecated Use withRestNamespace() instead
     * @param  bool|string  $restNamespace  The value to set for the restNamespace property.
     * @return self This method returns the current instance of the class.
     */
    public function withRestNamespace(bool|string $restNamespace): self
    {
        return $this->restNamespace($restNamespace);
    }

    /**
     * Sets the value of the restNamespace property.
     *
     * @deprecated Use restNamespace() instead
     * @param  bool|string  $restNamespace  The value to set for the restNamespace property.
     * @return self This method returns the current instance of the class.
     */
    public function setRestNamespace(bool|string $restNamespace): self
    {
        return $this->restNamespace($restNamespace);
    }

    /**
     * Retrieves the Rest Controller class for this instance.
     *
     * @return bool|string|null The Rest Controller class if set, otherwise false if not set.
     */
    public function getRestControllerClass(): bool|string|null
    {
        return $this->restControllerClass;
    }

    /**
     * Sets the value of the restControllerClass property.
     *
     * @param  bool|string  $restControllerClass  The value of the restControllerClass property.
     * @return self The current instance for method chaining.
     */
    public function restControllerClass(bool|string $restControllerClass): self
    {
        $this->restControllerClass = $restControllerClass;

        return $this;
    }

    /**
     * Sets the value of the restControllerClass property.
     *
     * @deprecated Use withRestControllerClass() instead
     * @param  bool|string  $restControllerClass  The value of the restControllerClass property.
     * @return self The current instance for method chaining.
     */
    public function withRestControllerClass(bool|string $restControllerClass): self
    {
        return $this->restControllerClass($restControllerClass);
    }

    /**
     * Sets the value of the restControllerClass property.
     *
     * @deprecated Use restControllerClass() instead
     * @param  bool|string  $restControllerClass  The value of the restControllerClass property.
     * @return self The current instance for method chaining.
     */
    public function setRestControllerClass(bool|string $restControllerClass): self
    {
        return $this->restControllerClass($restControllerClass);
    }

    /**
     * Retrieves the capabilities.
     *
     * @return array|null The capabilities array, or null if it is not set.
     */
    public function getCapabilities(): ?array
    {
        return $this->capabilities;
    }

    /**
     * Sets the capability for the object.
     *
     * @param  array  $capabilities  The capability to set.
     * @return self Returns a reference to the object.
     */
    public function capabilities(array $capabilities): self
    {
        $this->capabilities = $capabilities;

        return $this;
    }

    /**
     * Sets the capability for the object.
     *
     * @deprecated Use withCapabilities() instead
     * @param  array  $capabilities  The capability to set.
     * @return self Returns a reference to the object.
     */
    public function withCapabilities(array $capabilities): self
    {
        return $this->capabilities($capabilities);
    }

    /**
     * Sets the capability for the object.
     *
     * @deprecated Use capabilities() instead
     * @param  array  $capabilities  The capability to set.
     * @return self Returns a reference to the object.
     */
    public function setCapabilities(array $capabilities): self
    {
        return $this->capabilities($capabilities);
    }

    /**
     * Sets the value of the singular property.
     *
     * @param  string|null  $singular  The value to set for the singular property.
     * @return self Returns the instance of the class.
     */
    public function singular(?string $singular): self
    {
        $this->names['singular'] = $singular;

        return $this;
    }

    /**
     * Sets the value of the singular property.
     *
     * @deprecated Use withSingular() instead
     * @param  string|null  $singular  The value to set for the singular property.
     * @return self Returns the instance of the class.
     */
    public function withSingular(?string $singular): self
    {
        return $this->singular($singular);
    }

    /**
     * Sets the value of the singular property.
     *
     * @deprecated Use singular() instead
     * @param  string|null  $singular  The value to set for the singular property.
     * @return self Returns the instance of the class.
     */
    public function setSingular(?string $singular): self
    {
        return $this->singular($singular);
    }

    /**
     * Sets the value of the plural property.
     *
     * @param  string|null  $plural  The new value for the plural property.
     * @return self Returns the instance of the current object.
     */
    public function plural(?string $plural): self
    {
        $this->names['plural'] = $plural;

        return $this;
    }

    /**
     * Sets the value of the plural property.
     *
     * @deprecated Use withPlural() instead
     * @param  string|null  $plural  The new value for the plural property.
     * @return self Returns the instance of the current object.
     */
    public function withPlural(?string $plural): self
    {
        return $this->plural($plural);
    }

    /**
     * Sets the value of the plural property.
     *
     * @deprecated Use plural() instead
     * @param  string|null  $plural  The new value for the plural property.
     * @return self Returns the instance of the current object.
     */
    public function setPlural(?string $plural): self
    {
        return $this->plural($plural);
    }

    /**
     * Sets the slug for the object.
     *
     * This method sets the slug for the object. The slug is used as a unique identifier
     * for the object and can be used in various operations.
     *
     * @param  string|null  $slug  The slug to be set for the object. If null, the slug will be unset.
     * @return self Returns the current object instance.
     */
    public function slug(?string $slug): self
    {
        $this->names['slug'] = $slug;

        return $this;
    }

    /**
     * Sets the slug for the object.
     *
     * This method sets the slug for the object. The slug is used as a unique identifier
     * for the object and can be used in various operations.
     *
     * @deprecated Use withSlug() instead
     * @param  string|null  $slug  The slug to be set for the object. If null, the slug will be unset.
     * @return self Returns the current object instance.
     */
    public function withSlug(?string $slug): self
    {
        return $this->slug($slug);
    }

    /**
     * Sets the slug for the object.
     *
     * This method sets the slug for the object. The slug is used as a unique identifier
     * for the object and can be used in various operations.
     *
     * @deprecated Use slug() instead
     * @param  string|null  $slug  The slug to be set for the object. If null, the slug will be unset.
     * @return self Returns the current object instance.
     */
    public function setSlug(?string $slug): self
    {
        return $this->slug($slug);
    }

    /**
     * Sets the names property with the given array.
     *
     * @param  array  $names  The names to be set.
     * @return $this The current instance of the class.
     */
    public function names(array $names): self
    {
        $this->names = $names;

        return $this;
    }

    /**
     * Sets the names property with the given array.
     *
     * @deprecated Use withNames() instead
     * @param  array  $names  The names to be set.
     * @return $this The current instance of the class.
     */
    public function withNames(array $names): self
    {
        return $this->names($names);
    }

    /**
     * Sets the names property with the given array.
     *
     * @deprecated Use names() instead
     * @param  array  $names  The names to be set.
     * @return $this The current instance of the class.
     */
    public function setNames(array $names): self
    {
        return $this->names($names);
    }

    /**
     * Retrieves the value of the names property.
     *
     * @return array The value of the names property.
     */
    public function getNames(): array
    {
        return $this->names ?? [];
    }

    /**
     * Check if the dashboard glance is enabled or disabled.
     *
     * @return bool|null Returns true if the dashboard glance is enabled, false if it is disabled, or null if not set.
     */
    public function isDashboardGlance(): ?bool
    {
        return $this->dashboardGlance;
    }

    /**
     * Enables the dashboard glance feature.
     *
     * @return self The current instance of the class.
     */
    public function enableDashboardGlance(): self
    {
        $this->dashboardGlance = true;

        return $this;
    }

    /**
     * Disables the dashboard glance feature.
     *
     * @return self The current instance of the class.
     */
    public function disableDashboardGlance(): self
    {
        $this->dashboardGlance = false;

        return $this;
    }

    /**
     * Set the value of dashboard glance.
     *
     * @param  bool  $dashboardGlance  The new value for dashboard glance.
     * @return self Returns this object instance.
     */
    public function withDashboardGlance(bool $dashboardGlance): self
    {
        $this->dashboardGlance = $dashboardGlance;

        return $this;
    }

    /**
     * Set the value of dashboard glance.
     *
     * @deprecated Use withDashboardGlance() instead
     * @param  bool  $dashboardGlance  The new value for dashboard glance.
     * @return self Returns this object instance.
     */
    public function setDashboardGlance(bool $dashboardGlance): self
    {
        return $this->withDashboardGlance($dashboardGlance);
    }

    /**
     * Returns the admin columns for the current object.
     *
     * @return array|null The admin columns array or null if no admin columns are defined.
     */
    public function getAdminCols(): ?array
    {
        return $this->adminCols;
    }

    /**
     * Sets the value of the adminCols property.
     *
     * @param  array  $adminCols  The value to set for the adminCols property.
     * @return self Returns this object instance.
     */
    public function adminCols(array $adminCols): self
    {
        $this->adminCols = $adminCols;

        return $this;
    }

    /**
     * Sets the value of the adminCols property.
     *
     * @deprecated Use withAdminCols() instead
     * @param  array  $adminCols  The value to set for the adminCols property.
     * @return self Returns this object instance.
     */
    public function withAdminCols(array $adminCols): self
    {
        return $this->adminCols($adminCols);
    }

    /**
     * Sets the value of the adminCols property.
     *
     * @deprecated Use adminCols() instead
     * @param  array  $adminCols  The value to set for the adminCols property.
     * @return self Returns this object instance.
     */
    public function setAdminCols(array $adminCols): self
    {
        return $this->adminCols($adminCols);
    }

    /**
     * Gets the entity type name.
     *
     * @return string The entity type name
     */
    public function getEntity(): string
    {
        return $this->entity;
    }

    /**
     * Gets the slug of the entity.
     *
     * @return string The slug
     */
    public function getSlug(): string
    {
        return $this->names['slug'] ?? '';
    }

    /**
     * Translate the arguments using the given entity and keys.
     *
     * This is a stub implementation that returns arguments unchanged.
     * Override this method in subclasses if translation is needed.
     *
     * @param  array<string, mixed>  $args  The arguments to be translated
     * @param  string  $entity  The translation domain/entity to use
     * @param  array<int, string>  $keyToTranslate  The keys to be translated
     * @return array<string, mixed> The arguments (unchanged in this implementation)
     */
    public function translateArguments(
        array $args,
        string $entity,
        array $keyToTranslate = [
            'label',
            'labels.*',
            'names.singular',
            'names.plural',
        ]
    ): array {
        // Stub implementation - returns arguments unchanged
        // This can be overridden in subclasses if translation is needed
        return $args;
    }

    /**
     * Initializes the object by setting its singular and plural forms.
     *
     * This method must be implemented by concrete classes.
     *
     * @return void
     */
    abstract public function init();

    /**
     * Get the arguments for the entity.
     *
     * @return array|null The arguments for the entity.
     */
    public function getArgs(): ?array
    {
        $args = $this->buildArguments();
        unset($args['priority']);

        return $args;
    }
}
