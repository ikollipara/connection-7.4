/*
|--------------------------------------------------------------------------
| Input.jsx 
|--------------------------------------------------------------------------
|
| Forms Input Component.
*/

export default function Input({
    label,
    name,
    type = "text",
    value,
    onChange,
    error,
    ...props
}) {
    return (
        <div className="field">
            <label className="label" htmlFor={name}>
                {label}
            </label>
            <div className="control is-expanded">
                <input
                    className={`input ${error ? "is-danger" : ""}`}
                    type={type}
                    name={name}
                    id={name}
                    value={value}
                    onChange={onChange}
                    {...props}
                />
            </div>
            {error && <p className="help is-danger">{error}</p>}
        </div>
    );
}
