<?php

declare(strict_types=1);

namespace Pollora\Entity\Application\Services;

use Pollora\Entity\Domain\Contracts\ArgumentTranslatorInterface;
use Pollora\Entity\Domain\Contracts\EntityRegistrarInterface;
use Pollora\Entity\Domain\Models\PostType;
use Pollora\Entity\Domain\Models\Taxonomy;
use Pollora\Entity\Infrastructure\Services\NullArgumentTranslator;

/**
 * Application service for registering entities.
 *
 * This service orchestrates the registration of domain entities by delegating
 * to the appropriate registrars and handles argument translation.
 */
class EntityRegistrationService
{
    /**
     * The argument translator instance.
     */
    private ArgumentTranslatorInterface $argumentTranslator;

    /**
     * Flag to determine if we should apply translations.
     */
    private bool $shouldTranslate;

    /**
     * Constructor.
     *
     * @param  EntityRegistrarInterface  $postTypeRegistrar  Registrar for post types
     * @param  EntityRegistrarInterface  $taxonomyRegistrar  Registrar for taxonomies
     * @param  ArgumentTranslatorInterface|null  $argumentTranslator  Translator for arguments
     */
    public function __construct(
        private EntityRegistrarInterface $postTypeRegistrar,
        private EntityRegistrarInterface $taxonomyRegistrar,
        ?ArgumentTranslatorInterface $argumentTranslator = null
    ) {
        $this->argumentTranslator = $argumentTranslator ?? new NullArgumentTranslator;
        $this->shouldTranslate = ! ($this->argumentTranslator instanceof NullArgumentTranslator);
    }

    /**
     * Register a post type.
     *
     * @param  PostType  $postType  The post type to register
     * @return bool True if registration was successful
     */
    public function registerPostType(PostType $postType): bool
    {
        // If no custom translator is provided, just register the original post type
        if (! $this->shouldTranslate) {
            return $this->postTypeRegistrar->register($postType);
        }

        // Make a copy of the post type for translation
        $postTypeToRegister = clone $postType;

        // Get the post type arguments and names in array format
        $args = $postTypeToRegister->toArray();
        $names = $args['names'] ?? [];
        unset($args['names']);

        // Translate the arguments
        $translatedArgs = $this->argumentTranslator->translate($args, $postTypeToRegister->getEntity());

        // Apply translations back to the post type
        $this->applyTranslationsToPostType($postTypeToRegister, $translatedArgs);

        // Translate names separately
        $translatedNames = $this->argumentTranslator->translate(['names' => $names], $postTypeToRegister->getEntity());
        if (isset($translatedNames['names']['singular'])) {
            $postTypeToRegister->setSingular($translatedNames['names']['singular']);
        }
        if (isset($translatedNames['names']['plural'])) {
            $postTypeToRegister->setPlural($translatedNames['names']['plural']);
        }

        // Translate basic properties
        $basicProps = [
            'singular' => $postTypeToRegister->getSingular(),
            'plural' => $postTypeToRegister->getPlural(),
        ];
        $translatedBasicProps = $this->argumentTranslator->translate($basicProps, $postTypeToRegister->getEntity());
        if (isset($translatedBasicProps['singular'])) {
            $postTypeToRegister->setSingular($translatedBasicProps['singular']);
        }
        if (isset($translatedBasicProps['plural'])) {
            $postTypeToRegister->setPlural($translatedBasicProps['plural']);
        }

        return $this->postTypeRegistrar->register($postTypeToRegister);
    }

    /**
     * Register a taxonomy.
     *
     * @param  Taxonomy  $taxonomy  The taxonomy to register
     * @return bool True if registration was successful
     */
    public function registerTaxonomy(Taxonomy $taxonomy): bool
    {
        // If no custom translator is provided, just register the original taxonomy
        if (! $this->shouldTranslate) {
            return $this->taxonomyRegistrar->register($taxonomy);
        }

        // Make a copy of the taxonomy for translation
        $taxonomyToRegister = clone $taxonomy;

        // Get the taxonomy arguments and names in array format
        $args = $taxonomyToRegister->toArray();
        $names = $args['names'] ?? [];
        unset($args['names']);

        // Translate the arguments
        $translatedArgs = $this->argumentTranslator->translate($args, $taxonomyToRegister->getEntity());

        // Apply translations back to the taxonomy
        $this->applyTranslationsToTaxonomy($taxonomyToRegister, $translatedArgs);

        // Translate names separately
        $translatedNames = $this->argumentTranslator->translate(['names' => $names], $taxonomyToRegister->getEntity());
        if (isset($translatedNames['names']['singular'])) {
            $taxonomyToRegister->setSingular($translatedNames['names']['singular']);
        }
        if (isset($translatedNames['names']['plural'])) {
            $taxonomyToRegister->setPlural($translatedNames['names']['plural']);
        }

        // Translate basic properties
        $basicProps = [
            'singular' => $taxonomyToRegister->getSingular(),
            'plural' => $taxonomyToRegister->getPlural(),
        ];
        $translatedBasicProps = $this->argumentTranslator->translate($basicProps, $taxonomyToRegister->getEntity());
        if (isset($translatedBasicProps['singular'])) {
            $taxonomyToRegister->setSingular($translatedBasicProps['singular']);
        }
        if (isset($translatedBasicProps['plural'])) {
            $taxonomyToRegister->setPlural($translatedBasicProps['plural']);
        }

        return $this->taxonomyRegistrar->register($taxonomyToRegister);
    }

    /**
     * Check if a post type exists.
     *
     * @param  string  $slug  The slug of the post type to check
     * @return bool True if the post type exists
     */
    public function postTypeExists(string $slug): bool
    {
        return $this->postTypeRegistrar->exists($slug);
    }

    /**
     * Check if a taxonomy exists.
     *
     * @param  string  $slug  The slug of the taxonomy to check
     * @return bool True if the taxonomy exists
     */
    public function taxonomyExists(string $slug): bool
    {
        return $this->taxonomyRegistrar->exists($slug);
    }

    /**
     * Unregister a post type.
     *
     * @param  string  $slug  The slug of the post type to unregister
     * @return bool True if unregistration was successful
     */
    public function unregisterPostType(string $slug): bool
    {
        return $this->postTypeRegistrar->unregister($slug);
    }

    /**
     * Unregister a taxonomy.
     *
     * @param  string  $slug  The slug of the taxonomy to unregister
     * @return bool True if unregistration was successful
     */
    public function unregisterTaxonomy(string $slug): bool
    {
        return $this->taxonomyRegistrar->unregister($slug);
    }

    /**
     * Apply translated arguments back to the PostType object.
     *
     * @param  PostType  $postType  The post type to update
     * @param  array  $translatedArgs  The translated arguments
     */
    private function applyTranslationsToPostType(PostType $postType, array $translatedArgs): void
    {
        // Apply label translation
        if (isset($translatedArgs['label'])) {
            $postType->setLabel($translatedArgs['label']);
        }

        // Apply labels array translation
        if (isset($translatedArgs['labels'])) {
            $postType->setLabels($translatedArgs['labels']);
        }

        // Apply description translation
        if (isset($translatedArgs['description'])) {
            $postType->setDescription($translatedArgs['description']);
        }

        // You could add more fields that need translation here
    }

    /**
     * Apply translated arguments back to the Taxonomy object.
     *
     * @param  Taxonomy  $taxonomy  The taxonomy to update
     * @param  array  $translatedArgs  The translated arguments
     */
    private function applyTranslationsToTaxonomy(Taxonomy $taxonomy, array $translatedArgs): void
    {
        // Apply label translation
        if (isset($translatedArgs['label'])) {
            $taxonomy->setLabel($translatedArgs['label']);
        }

        // Apply labels array translation
        if (isset($translatedArgs['labels'])) {
            $taxonomy->setLabels($translatedArgs['labels']);
        }

        // You could add more fields that need translation here
    }
}
