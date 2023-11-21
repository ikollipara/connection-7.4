/*
|--------------------------------------------------------------------------
| File.jsx 
|--------------------------------------------------------------------------
|
| File Form Component.
*/

import { Upload } from "lucide-react";

export default function File({
    label,
    name,
    value,
    onChange,
    error,
    ...props
}) {
    return (
        <div className="field">
            <div className="control">
                <label className="label">{label}</label>
            </div>
            <div className="control">
                <div className="file has-name is-boxed">
                    <label className="file-label">
                        <input
                            {...props}
                            type="file"
                            name={name}
                            value={value}
                            onChange={onChange}
                            className={`input ${error && "is-danger"}`}
                        />
                        <span className="file-cta">
                            <span className="file-icon">
                                <Upload width={50} height={50} />
                            </span>
                            <span className="file-labe">Choose a file...</span>
                        </span>
                        <span className="file-name">{value && value.name}</span>
                    </label>
                </div>
            </div>
            {error && <p className="help is-danger">{error}</p>}
        </div>
    );
}
