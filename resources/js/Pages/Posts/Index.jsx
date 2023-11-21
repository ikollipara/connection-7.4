/*
|--------------------------------------------------------------------------
| Index.jsx 
|--------------------------------------------------------------------------
|
| Post Index View
*/

import Layout from "../../layouts/Layout";
import Hero from "../../components/Hero";
import { usePage } from "@inertiajs/react";
import PostCard from "../../components/PostCard";

export default function Index() {
    const { status, posts } = usePage().props;
    return (
        <Layout title={`ConneCTIOn - ${status}`}>
            <Hero className="is-primary">
                <h1 className="title is-3">My {status} Posts</h1>
                {status === "archived" && (
                    <p className="content">
                        Archived posts are similar to unlisted videos, if
                        someone has the link they can access. But the post is
                        not searchable.
                    </p>
                )}
            </Hero>
            <section className="container">
                {posts.map((post) => (
                    <PostCard
                        key={post.id}
                        post={post}
                        isArchived={status === "archived"}
                    />
                ))}
            </section>
        </Layout>
    );
}
