/*
|--------------------------------------------------------------------------
| Navbar.jsx 
|--------------------------------------------------------------------------
|
| This file defines the navbar of the application.
*/

import { Link, usePage } from "@inertiajs/react";
import Logo from "./Logo";
import { useState } from "react";

function GuestNavbar(active, setActive) {
    return (
        <>
            <nav className="navbar is-light">
                <div className="navbar-brand">
                    <Link className="navbar-item" href={route("index")}>
                        <Logo width={100} height={55} />
                    </Link>
                    <a
                        id="hamburger"
                        onClick={() => setActive(!active)}
                        className={`navbar-burger ${active ? "is-active" : ""}`}
                        aria-label="menu"
                        aria-expanded="false"
                        role="button"
                        data-target="navbarBasicExample"
                    >
                        {" "}
                        <span aria-hidden="true"></span>{" "}
                        <span aria-hidden="true"></span>{" "}
                        <span aria-hidden="true"></span>{" "}
                    </a>
                </div>
                <div className="navbar-menu">
                    <ul className="navbar-start">
                        <Link
                            href={route("index")}
                            className="navbar-item mt-2 mb-2"
                        >
                            Home
                        </Link>
                        <Link
                            href={route("about")}
                            className="navbar-item mt-2 mb-2"
                        >
                            About
                        </Link>
                    </ul>
                    <ul className="navbar-end">
                        <li className="navbar-item">
                            <Link
                                href={route("registration.create")}
                                className="button is-primary is-outlined"
                            >
                                Sign Up
                            </Link>
                        </li>
                        <li className="navbar-item">
                            <Link
                                href={route("login.create")}
                                className="button is-primary"
                            >
                                Login
                            </Link>
                        </li>
                    </ul>
                </div>
            </nav>
        </>
    );
}

function AuthenticatedNavbar(active, setActive, user) {
    return (
        <>
            <nav className="navbar is-light">
                <div className="navbar-brand">
                    <Link href={route("home")}>
                        <Logo width={100} height={55} />
                    </Link>
                    <a
                        id="hamburger"
                        onClick={() => setActive(!active)}
                        className={`navbar-burger ${active ? "is-active" : ""}`}
                        aria-label="menu"
                        aria-expanded="false"
                        role="button"
                        data-target="navbarBasicExample"
                    >
                        {" "}
                        <span aria-hidden="true"></span>{" "}
                        <span aria-hidden="true"></span>{" "}
                        <span aria-hidden="true"></span>{" "}
                    </a>
                </div>
                <div className="navbar-menu">
                    <ul className="navbar-start">
                        <div className="navbar-item has-dropdown is-hoverable">
                            <p className="navbar-link mt-2 mb-2">Posts</p>
                            <div className="navbar-dropdown">
                                <Link
                                    href={route("posts.index", {
                                        status: "draft",
                                    })}
                                    className="navbar-item"
                                >
                                    Post Drafts
                                </Link>
                                <Link
                                    href={route("posts.index", {
                                        status: "published",
                                    })}
                                    className="navbar-item"
                                >
                                    Published Posts
                                </Link>
                                <Link
                                    href={route("posts.index", {
                                        status: "archived",
                                    })}
                                    className="navbar-item"
                                >
                                    Archived Posts
                                </Link>
                                <span className="navbar-divider"></span>
                                <Link
                                    href={route("posts.create")}
                                    className="navbar-item"
                                >
                                    Create Post
                                </Link>
                            </div>
                        </div>
                        <div className="navbar-item has-dropdown is-hoverable">
                            <p className="navbar-link mt-2 mb-2">Collections</p>
                            <div className="navbar-dropdown">
                                <Link
                                    href={route("collections.index", {
                                        status: "draft",
                                    })}
                                    className="navbar-item"
                                >
                                    Collection Drafts
                                </Link>
                                <Link
                                    href={route("collections.index", {
                                        status: "published",
                                    })}
                                    className="navbar-item"
                                >
                                    Published Collection
                                </Link>
                                <Link
                                    href={route("collections.index", {
                                        status: "archived",
                                    })}
                                    className="navbar-item"
                                >
                                    Archived Collection
                                </Link>
                                <span className="navbar-divider"></span>
                                <Link
                                    href={route("collections.create")}
                                    className="navbar-item"
                                >
                                    Create Collection
                                </Link>
                            </div>
                        </div>
                    </ul>
                    <ul className="navbar-end">
                        <li className="navbar-item">
                            <img src={user.avatar} alt="User Avatar" />
                        </li>
                        <li className="navbar-item">
                            <Link
                                href={route("users.show", user.id)}
                                className="button is-primary is-outlined"
                            >
                                My Profile
                            </Link>
                        </li>
                        <li className="navbar-item">
                            <Link
                                href={route("logout")}
                                method="delete"
                                as="button"
                                className="button is-primary is-outlined"
                            >
                                Logout
                            </Link>
                        </li>
                    </ul>
                </div>
            </nav>
        </>
    );
}

/**
 * Navbar component
 * The application navbar.
 */
export default function Navbar() {
    const { user } = usePage().props.auth;
    const [active, setActive] = useState(false);

    return user
        ? AuthenticatedNavbar(active, setActive, user)
        : GuestNavbar(active, setActive);
}
