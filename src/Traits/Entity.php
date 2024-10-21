<?php

declare(strict_types=1);

namespace Pollora\Entity\Traits;

use Pollora\Entity\Traits\ArgumentTranslater;
use Pollora\WordPressArgs\ArgumentHelper;

/**
 * The ArgumentHelper class is a abstract that provides methods to extract arguments from properties using getter methods.
 */
abstract class Entity
{
    use ArgumentTranslater, ArgumentHelper;

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
     * Retrieves the label for the entity.
     *
     * @return string|null Returns the label for the entity as a string.
     *                    If the label is set, the method will return the label string.
     *                    If the label is not set, the method will return null.
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * Sets the label for the entity.
     *
     * @param  string  $label The label to set for the entity.
     * @return self Returns the instance of the class for method chaining.
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Retrieves the labels associated with the entity.
     *
     * @return array|null Returns an object containing the labels associated with the entity.
     *                      If labels are available, an array is returned with the label properties.
     *                      If labels are not available, null is returned.
     */
    public function getLabels(): ?array
    {
        return $this->labels;
    }

    /**
     * Sets the labels for the entity.
     *
     * @param  array  $labels The labels array containing the labels for the entity.
     * @return self Returns an instance of the class.
     */
    public function setLabels(array $labels): self
    {
        $this->labels = $labels;

        return $this;
    }

    /**
     * Retrieves the description for the entity.
     *
     * @return string|null Returns the description for the entity.
     *                    If the value is null, no description is available.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Sets the description of the entity.
     *
     * @param  string  $description The description of the entity.
     * @return self Returns an instance of the class with the updated description.
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Checks if the entity is public.
     *
     * @return bool|null Returns a boolean indicating if the entity is public.
     *                  If the value is true, the entity is public.
     *                  If the value is false, the entity is not public.
     *                  If the value is null, the entity's visibility is not defined and may require further processing.
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
     * @param  bool  $public The boolean indicating if the entity should be public or not.
     * @return self Returns the modified instance of the object.
     */
    public function setPublic(bool $public): self
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Checks if the entity is publicly queryable.
     *
     * @return bool|null Returns a boolean indicating if the entity is publicly queryable.
     *                  If the value is true, the entity is publicly queryable.
     *                  If the value is false, the entity is not publicly queryable.
     *                  If the value is null, the value is not defined and may require further processing.
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
     * Sets whether the entity can be publicly queried.
     *
     * @param  bool|null  $publiclyQueryable The value indicating whether the entity can be publicly queried.
     * @return self Returns an instance of the current object.
     */
    public function setPubliclyQueryable(?bool $publiclyQueryable): self
    {
        $this->publiclyQueryable = $publiclyQueryable;

        return $this;
    }

    /**
     * Check if the entity is hierarchical or not.
     *
     * @return bool|null Returns the hierarchical status of the capability. If the capability is
     * hierarchical (true), returns true. If the capability is not hierarchical (false), returns
     * false. If the hierarchical status is unknown, returns null.
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
     * Gets the value of the showUi property.
     *
     * @return bool|null Returns a boolean indicating if the UI should be shown for this entity.
     *                  If the value is true, the UI should be shown.
     *                  If the value is false, the UI should not be shown.
     *                  If the value is null, the decision is not defined and may require further processing.
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
     * Sets whether the UI should be displayed for the entity.
     *
     * @param  bool|null  $showUi The value indicating if the UI should be displayed.
     *                          - If the value is true, the UI should be displayed.
     *                          - If the value is false, the UI should not be displayed.
     *                          - If the value is null, the decision is not defined and may require further processing.
     * @return self The updated instance of the class.
     */
    public function setShowUi(?bool $showUi): self
    {
        $this->showUi = $showUi;

        return $this;
    }

    /**
     * Checks if the entity should be displayed in the menu.
     *
     * @return bool|string|null Returns a boolean indicating if the entity should be displayed in the menu.
     *                         If the value is true, the entity should be displayed.
     *                         If the value is false, the entity should not be displayed.
     *                         If the value is null, the decision is not defined and may require further processing.
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
     * Set the value for the showInMenu property.
     *
     * @param  bool|string  $showInMenu The value to set for the showInMenu property.
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
     * Sets whether the entity should be displayed in navigation menus.
     *
     * @param  bool|null  $showInNavMenus Whether the entity should be displayed in navigation menus.
     *                                  Set to true if the entity should be displayed, false if it should not be displayed,
     *                                  or null if the entity's visibility in navigation menus should not be modified.
     * @return self Returns the modified instance of the object.
     */
    public function setShowInNavMenus(?bool $showInNavMenus): self
    {
        $this->showInNavMenus = $showInNavMenus;

        return $this;
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
     * @param  bool|string  $queryVar The new value for the queryVar property.
     * @return self The instance of the object.
     */
    public function setQueryVar(bool|string $queryVar): self
    {
        $this->queryVar = $queryVar;

        return $this;
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
     * @param  bool|array  $rewrite The new value for the rewrite property.
     * @return self Returns an instance of the current object.
     */
    public function setRewrite(bool|array $rewrite): self
    {
        $this->rewrite = $rewrite;

        return $this;
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
     * Sets the value of the showInRest property.
     *
     * @param  bool  $showInRest The new value for the showInRest property.
     * @return self The current object with the updated showInRest property.
     */
    public function setShowInRest(bool $showInRest): self
    {
        $this->showInRest = $showInRest;

        return $this;
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
     * @param  bool|string  $restBase The value to set for the restBase property.
     * @return self This instance of the object.
     */
    public function setRestBase(bool|string $restBase): self
    {
        $this->restBase = $restBase;

        return $this;
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
     * @param  bool|string  $restNamespace The value to set for the restNamespace property.
     * @return self This method returns the current instance of the class.
     */
    public function setRestNamespace(bool|string $restNamespace): self
    {
        $this->restNamespace = $restNamespace;

        return $this;
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
     * @param  bool|string  $restControllerClass The value of the restControllerClass property.
     * @return self The current instance for method chaining.
     */
    public function setRestControllerClass(bool|string $restControllerClass): self
    {
        $this->restControllerClass = $restControllerClass;

        return $this;
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
     * @param  array  $capabilities The capability to set.
     * @return self Returns a reference to the object.
     */
    public function setCapabilities(array $capabilities): self
    {
        $this->capabilities = $capabilities;

        return $this;
    }

    /**
     * Sets the value of the singular property.
     *
     * @param  string|null  $singular The value to set for the singular property.
     */
    public function setSingular(?string $singular): self
    {
        $this->names['singular'] = $singular;

        return $this;
    }

    /**
     * Sets the value of the plural property.
     *
     * @param  string|null  $plural The new value for the plural property.
     * @return self Returns the instance of the current object.
     */
    public function setPlural(?string $plural): self
    {
        $this->names['plural'] = $plural;

        return $this;
    }

    /**
     * Sets the slug for the object.
     *
     * This method sets the slug for the object. The slug is used as a unique identifier
     * for the object and can be used in various operations.
     *
     * @param  string|null  $slug The slug to be set for the object. If null, the slug will be unset.
     * @return self Returns the current object instance.
     */
    public function setSlug(?string $slug): self
    {
        $this->names['slug'] = $slug;

        return $this;
    }

    /**
     * Sets the names property with the given array.
     *
     * @param  array  $names The names to be set.
     * @return $this The current instance of the class.
     */
    public function setNames(array $names): self
    {
        $this->names = $names;

        return $this;
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
     * Set the value of dashboard glance.
     *
     * @param  bool  $dashboardGlance The new value for dashboard glance.
     */
    public function setDashboardGlance(bool $dashboardGlance): self
    {
        $this->dashboardGlance = $dashboardGlance;

        return $this;
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
     * @param  array  $adminCols The value to set for the adminCols property.
     */
    public function setAdminCols(array $adminCols): self
    {
        $this->adminCols = $adminCols;

        return $this;
    }

    /**
     * Initializes the object by setting its singular and plural forms and registering it.
     *
     * @return void
     */
    public function init()
    {
        $this->setSingular($this->singular);
        $this->setPlural($this->plural);
        $this->register();
    }

    /**
     * Registers the entity type.
     *
     * This method is called during initialization to register the entity type.
     * It adds an anonymous function to the 'init' action hook with a priority of 99.
     * The anonymous function calls the 'registerEntityType' method.
     *
     * @return void
     */
    public function register()
    {
        if (function_exists('register_post_type')) {
            $this->registerEntityType();

            return;
        }

        add_action('init', function () {
            $this->registerEntityType();
        }, 99);
    }

    /**
     * Register the entity type.
     *
     * @return void
     */
    public function registerEntityType()
    {
        $args = $this->buildArguments();
        $args['names'] = $this->getNames();
        
        $args = $this->translateArguments($args, $this->entity);
        $names = $args['names'];
        unset($args['names']);
        //dd($args);

        if ($this->entity === 'taxonomies') {
            $this->registerTaxonomy($args, $names);
        } else {
            $this->registerPostType($args, $names);
        }
    }

    /**
     * Registers a custom taxonomy.
     *
     * @param  array  $args The arguments for registering the taxonomy.
     * @param  array  $names The names for the taxonomy.
     * @return void
     */
    public function registerTaxonomy($args, $names)
    {
        register_extended_taxonomy($this->slug, $this->objectType, $args, $names);
    }

    /**
     * Registers a custom post type using register_extended_post_type function
     *
     * @param  array  $args An array of arguments for registering the post type
     * @param  array  $names An array of names for labeling the post type
     * @return void
     */
    public function registerPostType($args, $names)
    {
        register_extended_post_type($this->slug, $args, $names);
    }
}
