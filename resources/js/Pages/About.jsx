/*
|--------------------------------------------------------------------------
| About.jsx 
|--------------------------------------------------------------------------
|
| The About Page.
*/

import Layout from "../layouts/Layout";
import Hero from "../components/Hero";

export default function About() {
    return (
        <Layout title="ConneCTION - About">
            <Hero className="is-primary">
                <h1 className="title">About Us</h1>
            </Hero>
            <section className="container is-fluid mt-5">
                <h2 className="title is-1">
                    Where it started<span className="has-text-primary">.</span>
                </h2>
                <hr />
                <section className="columns">
                    <div className="column is-two-thirds content is-large">
                        AIR@NE was a NSF-funded grant that examined the
                        adaptation and implementation of a validated K-8
                        Computer Science curriculum in diverse school districts.
                        The grant expanded the Research-Practitioner Partnership
                        between the University of Nebraska-Lincoln and Lincoln
                        Public Schools (LPS) to other districts across Nebraska.{" "}
                        <br />
                        <br />
                        The primary goal was to study how districts facing
                        different contextual challenges, including rural
                        schools, majority-minority schools, and Native American
                        reservation schools, adapt the curriculum to fit local
                        needs and strengths to broaden participation in computer
                        science.
                    </div>
                    <div className="column">
                        <img src="images/airne_personnel.webp" alt="" />
                    </div>
                </section>
                <section className="columns">
                    <div className="column">
                        <img src="images/AIRNE-C1-5-MAP.webp" alt="" />
                    </div>
                    <div className="column is-half content is-large">
                        <h2 className="title is-1">
                            The Idea<span className="has-text-primary">.</span>
                        </h2>
                        AIR@NE connected teachers across the state of Nebraska,
                        from the panhandle to Omaha and Lincoln. This statewide
                        community helped connect CS teachers to other CS
                        teachers. It created a place to learn and grow that
                        wasn't bound by distance. <br />
                        <br />
                        As more states add CS to their standards, we realized
                        there might be a spot for an online PLC, centered around
                        CS.
                    </div>
                </section>
            </section>
        </Layout>
    );
}
