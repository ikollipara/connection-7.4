/*
|--------------------------------------------------------------------------
| Home.jsx 
|--------------------------------------------------------------------------
|
| This file defines the home page of the application.
*/

import Hero from "../components/Hero";
import Logo from "../components/Logo";
import Layout from "../layouts/Layout";
import { Link } from "@inertiajs/react";
import { Newspaper, MessagesSquare, Layers } from "lucide-react";

export default function Home() {
    return (
        <Layout title="ConneCTION">
            <Hero className="is-success">
                <div className="has-flex has-flex-direction-col ml-5 has-text-left">
                    <p className="title">
                        <Logo width={300} height={125} />
                    </p>
                    <p className="subtitle">
                        Connecting Teachers across the country around Computer
                        Science Education
                    </p>
                    <div className="buttons">
                        <Link
                            href={route("about")}
                            className="button is-primary"
                        >
                            Learn More
                        </Link>
                        <Link
                            href={route("registration.create")}
                            className="button is-primary is-outlined"
                        >
                            Sign Up
                        </Link>
                    </div>
                </div>
            </Hero>
            <section className="column is-fullwidth mx-5">
                <section className="columns mt-5 mx-5">
                    <span className="column is-two-thirds">
                        <h2 className="title is-1 has-text-right">
                            Learn about CS, together{""}
                            <span className="has-text-primary">.</span>
                        </h2>
                        <p className="content is-medium">
                            Connect with teachers all over about Computer
                            Science. Learn from their experiences, share your
                            own. This is a community to help <em>You</em> grow!
                        </p>
                    </span>
                    <div
                        className="column is-one-third"
                        style={{
                            filter: "drop-shadow(0 4px 3px rgb(0 0 0 / 0.07)) drop-shadow(0 2px 2px rgb(0 0 0 / 0.06))",
                        }}
                    >
                        <img
                            src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2342&q=80"
                            alt=""
                            className="image"
                            style={{
                                borderRadius: "10% 0 10% 0",
                                border: "#003049 0.5rem solid",
                            }}
                        />
                    </div>
                </section>
                <section className="column is-fullwidth mx-5">
                    <span className="column is-four-fifths mx-auto">
                        <h2 className="title is-1 has-text-centered">
                            Connect and Create
                            <span className="has-text-primary">.</span>
                        </h2>
                        <p className="content is-large">
                            conneCTION is designed to let you create and connect
                            in many different ways.
                        </p>
                        <section className="columns">
                            <div className="column is-one-third has-text-centered">
                                <Newspaper width="50" height="50" />
                                <p className="title">Posts</p>
                                <p className="content is-medium">
                                    Showcase your knowledge and ideas through a
                                    rich post system. Other teachers can
                                    comment, like, or even favorite your post.
                                </p>
                            </div>
                            <div className="column is-one-third has-text-centered">
                                <MessagesSquare width="50" height="50" />
                                <p className="title">Comments</p>
                                <p className="content is-medium">
                                    Discuss with a community of interested
                                    individuals around posts and collections.
                                </p>
                            </div>
                            <div className="column is-one-third has-text-centered">
                                <Layers width="50" height="50" />
                                <p className="title">Collections</p>
                                <p className="content is-medium">
                                    Collect posts together into something
                                    shareable. Whether its for lesson planning
                                    or just to share, collections allow it all.
                                </p>
                            </div>
                        </section>
                    </span>
                </section>
            </section>
        </Layout>
    );
}
