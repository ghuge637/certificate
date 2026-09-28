package com.automation.system.certificate.dto;

import com.automation.system.certificate.model.User;

public class LoginResponse {
    private boolean success;
    private String message;
    private String redirectUrl;
    private User user;

    public LoginResponse() {
    }

    public LoginResponse(boolean success, String message, String redirectUrl, User user) {
        this.success = success;
        this.message = message;
        this.redirectUrl = redirectUrl;
        this.user = user;
    }

    public boolean isSuccess() {
        return success;
    }

    public void setSuccess(boolean success) {
        this.success = success;
    }

    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }

    public String getRedirectUrl() {
        return redirectUrl;
    }

    public void setRedirectUrl(String redirectUrl) {
        this.redirectUrl = redirectUrl;
    }

    public User getUser() {
        return user;
    }

    public void setUser(User user) {
        this.user = user;
    }
}
