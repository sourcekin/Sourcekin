<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 06.07.18.
 */

namespace Sourcekin\Tests\Unit\DependencyInjection;


use PHPUnit\Framework\TestCase;
use Sourcekin\Components\DependencyInjection\ResolvedDependencies;
use Sourcekin\Components\DependencyInjection\Resolver;

class ResolverTest extends TestCase {

    public function testResolve() {
        $resolver = new Resolver();
        $resolved = $resolver->resolve(
            [
                'articles_meta' => ['articles'],
                'articles'      => ['users', 'categories', 'tags'],
                'categories'    => [],
                'comments'      => ['users', 'articles'],
                'options'       => [],
                'tags'          => [],
                'users'         => [],
                'users_meta'    => ['users'],
            ]
        );

        $this->assertInstanceOf(ResolvedDependencies::class, $resolved);
        $this->assertTrue($resolved->isFullyResolved());
        $this->assertEquals(
            ['users', 'categories', 'tags', 'articles', 'articles_meta', 'comments', 'options', 'users_meta',],
            $resolved->getResolved()
        );
    }


    public function testResolveNoDependencies() {
        $resolved = (new Resolver())->resolve(['articles' => [], 'categories' => [], 'users' => []]);
        $this->assertTrue($resolved->isFullyResolved());
        $this->assertEquals(['articles', 'categories', 'users'], $resolved->getResolved());
    }


    /**
     * @expectedException \Sourcekin\Components\DependencyInjection\CircularReference
     */
    public function testCircularReference() {
        $resolver = new Resolver();
        $resolver->resolve(
            [
                'articles'      => ['articles_meta', 'comments'],
                'articles_meta' => ['comments'],
                'comments'      => ['articles'],
            ]
        );
    }

    public function testResolvePartial() {
        $resolver = new Resolver();
        $resolved = $resolver->resolve(
            [
                'articles' => ['articles_meta'],
                'comments' => ['articles']
            ]
        );
        $this->assertFalse($resolved->isFullyResolved());
    }
}