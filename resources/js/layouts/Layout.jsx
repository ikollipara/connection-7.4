/*
|--------------------------------------------------------------------------
| Layout.jsx 
|--------------------------------------------------------------------------
|
| This file defines the layout of the application.
*/

import { Head } from "@inertiajs/react";
import Navbar from "../components/Navbar";
import { usePage } from "@inertiajs/react";
import { toast } from "bulma-toast";

export default function Layout({ children, title }) {
    const { flash } = usePage().props;
    if (flash.message) {
        toast({
            message: flash.message,
        });
    }
    return (
        <>
            <Head title={title} />
            <main>
                <Navbar />
                {children}
            </main>
        </>
    );
}
