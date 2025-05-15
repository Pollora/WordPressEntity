<?php

declare(strict_types=1);

namespace Pollora\Entity\Tests\Feature;

use Mockery;
use Pollora\Entity\Application\Services\EntityRegistrationService;
use Pollora\Entity\Domain\Contracts\EntityRegistrarInterface;
use Pollora\Entity\Domain\Models\PostType;
use Pollora\Entity\Domain\Models\Taxonomy;
use Pollora\Entity\Tests\Stubs\MockArgumentTranslator;
use Pollora\Entity\Tests\TestCase;

class TranslationIntegrationTest extends TestCase
{
    /**
     * @var EntityRegistrarInterface|Mockery\MockInterface
     */
    private $postTypeRegistrar;

    /**
     * @var EntityRegistrarInterface|Mockery\MockInterface
     */
    private $taxonomyRegistrar;

    /**
     * @var MockArgumentTranslator
     */
    private $translator;

    /**
     * @var EntityRegistrationService
     */
    private $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->postTypeRegistrar = Mockery::mock(EntityRegistrarInterface::class);
        $this->taxonomyRegistrar = Mockery::mock(EntityRegistrarInterface::class);
        $this->translator = new MockArgumentTranslator;

        $this->service = new EntityRegistrationService(
            $this->postTypeRegistrar,
            $this->taxonomyRegistrar,
            $this->translator
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_post_type_registration_with_translation(): void
    {
        // Arrange
        $postType = new PostType('book', 'Book', 'Books');
        $postType->setLabel('Book Library');
        $postType->setDescription('Collection of books');
        $postType->setLabels([
            'name' => 'Books',
            'singular_name' => 'Book',
            'add_new' => 'Add New Book',
        ]);

        // Set up spy to capture the actual post type being registered
        $registeredPostType = null;
        $this->postTypeRegistrar->shouldReceive('register')
            ->once()
            ->with(Mockery::on(function ($arg) use (&$registeredPostType) {
                $registeredPostType = $arg;

                return true;
            }))
            ->andReturn(true);

        // Act
        $result = $this->service->registerPostType($postType);

        // Assert
        $this->assertTrue($result);
        $this->assertNotNull($registeredPostType);

        // Verify translated values
        $this->assertEquals('[post-types] Book Library', $registeredPostType->getLabel());
        $this->assertEquals('[post-types] Book', $registeredPostType->getSingular());
        $this->assertEquals('[post-types] Books', $registeredPostType->getPlural());

        // Check labels array
        $labels = $registeredPostType->getLabels();
        $this->assertEquals('[post-types] Books', $labels['name']);
        $this->assertEquals('[post-types] Book', $labels['singular_name']);
        $this->assertEquals('[post-types] Add New Book', $labels['add_new']);

        // Original post type should be unchanged
        $this->assertEquals('Book Library', $postType->getLabel());
        $this->assertEquals('Book', $postType->getSingular());
        $this->assertEquals('Books', $postType->getPlural());
    }

    public function test_taxonomy_registration_with_translation(): void
    {
        // Arrange
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');
        $taxonomy->setLabel('Book Genres');
        $taxonomy->setLabels([
            'name' => 'Genres',
            'singular_name' => 'Genre',
            'search_items' => 'Search Genres',
        ]);

        // Set up spy to capture the actual taxonomy being registered
        $registeredTaxonomy = null;
        $this->taxonomyRegistrar->shouldReceive('register')
            ->once()
            ->with(Mockery::on(function ($arg) use (&$registeredTaxonomy) {
                $registeredTaxonomy = $arg;

                return true;
            }))
            ->andReturn(true);

        // Act
        $result = $this->service->registerTaxonomy($taxonomy);

        // Assert
        $this->assertTrue($result);
        $this->assertNotNull($registeredTaxonomy);

        // Verify translated values
        $this->assertEquals('[taxonomies] Book Genres', $registeredTaxonomy->getLabel());
        $this->assertEquals('[taxonomies] Genre', $registeredTaxonomy->getSingular());
        $this->assertEquals('[taxonomies] Genres', $registeredTaxonomy->getPlural());

        // Check labels array
        $labels = $registeredTaxonomy->getLabels();
        $this->assertEquals('[taxonomies] Genres', $labels['name']);
        $this->assertEquals('[taxonomies] Genre', $labels['singular_name']);
        $this->assertEquals('[taxonomies] Search Genres', $labels['search_items']);

        // Original taxonomy should be unchanged
        $this->assertEquals('Book Genres', $taxonomy->getLabel());
        $this->assertEquals('Genre', $taxonomy->getSingular());
        $this->assertEquals('Genres', $taxonomy->getPlural());
    }
}
