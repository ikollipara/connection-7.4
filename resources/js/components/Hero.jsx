/*
|--------------------------------------------------------------------------
| Hero.jsx 
|--------------------------------------------------------------------------
|
| This file defines the hero of the application.
*/

export default function Hero({ className = "", children }) {
    return (
        <>
            <section className={`hero ${className}`}>
                <div className="hero-body">{children}</div>
            </section>
        </>
    );
}
