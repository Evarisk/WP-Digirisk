<?php
/**
 * Class SampleTest
 *
 * @package EO_Framework/Test
 */

/**
 * Sample test case.
 */
class TestPostClass extends WP_UnitTestCase {

	/**
	 * Testes de Post_Model.
	 *
	 * @dataProvider get_data
	 *
	 * @param array $data     Les données à tester. Défini dans get_data.
	 * @param array $expected Les données attendu lors des tests unitaires. Défini dans get_data.
	 *
	 * @return void
	 */
	function test_create_post( $data, $expected ) {
		$post = \eoxia\Post_Class::g()->create( $data, true );

		$this->assertInstanceOf($expected['is_instance'], $post);

		$this->assertEquals( $expected['data']['title'], $post->data['title'] );
		$this->assertInternalType( $expected['schema']['title']['type'], $post->data['title'] );

		$this->assertEquals( $expected['data']['author_id'], $post->data['author_id'] );
		$this->assertInternalType( $expected['schema']['author_id']['type'], $post->data['author_id'] );

		$this->assertEquals( $expected['data']['date'], $post->data['date']['raw'] );
		$this->assertInternalType( 'string', $post->data['date']['raw'] );

		$this->assertEquals( $expected['data']['slug'], $post->data['slug'] );
		$this->assertInternalType( $expected['schema']['slug']['type'], $post->data['slug'] );

		$this->assertEquals( $expected['data']['content'], $post->data['content'] );
		$this->assertInternalType( $expected['schema']['content']['type'], $post->data['content'] );

		$this->assertEquals( $expected['data']['link'], $post->data['link'] );
		$this->assertInternalType( $expected['schema']['link']['type'], $post->data['link'] );

		$this->assertEquals( $expected['data']['type'], $post->data['type'] );
		$this->assertInternalType( $expected['schema']['type']['type'], $post->data['type'] );

		$this->assertEquals( $expected['data']['order'], $post->data['order'] );
		$this->assertInternalType( $expected['schema']['order']['type'], $post->data['order'] );

		$this->assertEquals( $expected['data']['comment_status'], $post->data['comment_status'] );
		$this->assertInternalType( $expected['schema']['comment_status']['type'], $post->data['comment_status'] );

		$this->assertEquals( $expected['data']['comment_count'], $post->data['comment_count'] );
		$this->assertInternalType( $expected['schema']['comment_count']['type'], $post->data['comment_count'] );

		$this->assertEquals( $expected['data']['thumbnail_id'], $post->data['thumbnail_id'] );
		$this->assertInternalType( $expected['schema']['thumbnail_id']['type'], $post->data['thumbnail_id'] );

	}

	/**
	 * Les données défini pour la méthode test_create_post.
	 *
	 * @return array Les données à tester et les données attendues.
	 */
	function get_data() {
		$date = current_time( 'mysql' );

		return array(
			array(
				array(
					'title'     => 'Hello tout le monde !',
					'content'   => 'Mon super contenu !',
					'author_id' => 1,
					'date'      => $date,
				),
				array(
					'is_instance'      => \eoxia\Post_Model::class,
					'data'             => array(
						'title'          => 'Hello tout le monde !',
						'author_id'      => 1,
						'parent_id'      => 0,
						'date'           => $date,
						'slug'           => 'hello-tout-le-monde',
						'content'        => 'Mon super contenu !',
						'link'           => 'http://example.org/?p=3',
						'type'           => 'post',
						'order'          => 0,
						'comment_status' => 'open',
						'comment_count'  => 0,
						'thumbnail_id'   => 0,
					),
					'schema'           => \eoxia\Post_Class::g()->get_schema(),
				),
			),
		);
	}
}
