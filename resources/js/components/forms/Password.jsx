/*
|--------------------------------------------------------------------------
| Password.jsx 
|--------------------------------------------------------------------------
|
| Forms Password Component.
*/

import { Eye, EyeOff } from "lucide-react";
import { useState } from "react";

export default function Password({
    label,
    name,
    value,
    onChange,
    error,
    ...props
}) {
    const [showPassword, setShowPassword] = useState(false);
    return (
        <div className="field">
            <label className="label" htmlFor={name}>
                {label}
            </label>
            <div className="field has-addons">
                <div className="control is-expanded">
                    <input
                        className={`input ${error ? "is-danger" : ""}`}
                        type={showPassword ? "text" : "password"}
                        name={name}
                        id={name}
                        value={value}
                        onChange={onChange}
                        {...props}
                    />
                </div>
                <div className="control">
                    <button
                        className="button"
                        onClick={() => setShowPassword(!showPassword)}
                        type="button"
                    >
                        {showPassword ? <EyeOff /> : <Eye />}
                    </button>
                </div>
            </div>

            {error && <p className="help is-danger">{error}</p>}
        </div>
    );
}
