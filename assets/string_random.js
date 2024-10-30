var C9_STRING_RANDOM = function () {
    return (
        Math.random()
            .toString(36)
            .substring(7) +
        Math.random()
            .toString(36)
            .substring(7)
    );
};