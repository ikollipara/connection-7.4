/*
|--------------------------------------------------------------------------
| PostCard.jsx 
|--------------------------------------------------------------------------
|
| Post Card Component.
*/

import { Link } from "@inertiajs/react";

export default function PostCard({ post, isArchived = false }) {
    return (
        <article className="mt-3 mx-5">
            <div className="level">
                <div className="level-start">
                    <p className="title is-4">{post.title ?? "Unamed Post"}</p>
                </div>
                <div
                    className="level-end"
                    style={{ display: "inline-flex", gap: "1rem" }}
                >
                    <Link href={route("posts.edit", post.id)}>Edit</Link>
                    <Link
                        className="button is-primary"
                        href={
                            isArchived
                                ? route("posts.restore", post.id)
                                : route("posts.destroy", post.id)
                        }
                        method={isArchived ? "patch" : "delete"}
                        only={["posts"]}
                        as="button"
                    >
                        {isArchived ? "Restore" : "Delete"}
                    </Link>
                </div>
            </div>
            <table className="table is-fullwidth">
                <tbody>
                    <tr className="content is-italic">
                        <td>Last Updated</td>
                        <td>{post.updated_at}</td>
                    </tr>
                    {post.published && (
                        <>
                            <tr className="content is-italic">
                                <td>Views</td>
                                <td>{post.views}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <Link href={route("posts.show", post.id)}>
                                        Visit
                                    </Link>
                                </td>
                            </tr>
                        </>
                    )}
                </tbody>
            </table>
        </article>
    );
}
