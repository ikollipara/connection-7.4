/*
|--------------------------------------------------------------------------
| Create.jsx 
|--------------------------------------------------------------------------
|
| Session Creation Form (Login page).
*/

import Hero from "../../components/Hero";
import Input from "../../components/forms/Input";
import Password from "../../components/forms/Password";
import Layout from "../../layouts/Layout";
import { useForm } from "@inertiajs/react";

export default function Create() {
    const { data, setData, post, processing, errors } = useForm({
        email: "",
        password: "",
    });

    function submit(e) {
        e.preventDefault();
        post(route("login.store"), {
            onSuccess: () => {
                window.location.reload();
            },
        });
    }

    return (
        <Layout title="ConneCTION - Login">
            <Hero className="is-dark">
                <h1 className="title is-1">Login</h1>
            </Hero>
            <section className="container is-fluid">
                <form onSubmit={submit} className="mt-5 mb-5">
                    <Input
                        label="Email"
                        name="email"
                        type="email"
                        value={data.email}
                        error={errors.email}
                        onChange={(e) => setData("email", e.target.value)}
                    />
                    <Password
                        label="Password"
                        name="password"
                        value={data.password}
                        error={errors.password}
                        onChange={(e) => setData("password", e.target.value)}
                    />
                    <div className="field">
                        <div className="control">
                            <button
                                type="submit"
                                className={`button is-primary ${
                                    processing ? "is-loading" : ""
                                }`}
                            >
                                Login
                            </button>
                        </div>
                    </div>
                </form>
            </section>
        </Layout>
    );
}
