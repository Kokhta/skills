# Conversation Flow

This skill is conversational by design. Follow this exact turn structure. Do not skip turns. Do not bundle approval steps.

## Turn map

```
T1  user → triggers skill with inputs (path + screenshots/HTML/assets)
T2  skill → runs prechecks, presents preliminary inventory, asks confirmation
T3  user → confirms inventory or adjusts
T4  skill → proposes Design Tokens (colors + fonts)
T5  user → approves or adjusts tokens
T6  skill → writes tokens to active kit, proposes header
T7  user → approves header (or picks alternative)
T8  skill → builds header template, proposes footer
T9  user → approves footer
T10 skill → builds footer template, presents blueprint of PAGE 1
T11 user → approves page 1 blueprint or requests targeted changes
T12 skill → presents asset mapping for page 1
T13 user → confirms mapping
T14 skill → builds page 1 (draft → inject → validate → publish), delivers URL + screenshots
T15+ repeat for next page
```

## Rules per turn

### Inventory turn (T2)
- Be brief. Bullet list of detected pages with section count and shared regions.
- One question only at the end: "Confirm or adjust?"

### Design tokens turn (T4)
- Show 4–8 colors max with proposed Global IDs and roles (Primary, Secondary, Text, Accent, etc.).
- Show 2–3 font assignments (Primary heading, Secondary body, optional accent).
- One question: "Approve these tokens?"

### Header/Footer turns (T6, T8)
- Show 2 or 3 concrete widget combinations. Be specific:
  - "Option A: Container (flex row) + Site Logo + Nav Menu + Button"
  - "Option B: Container (flex row) + Image + Inner Container with Nav Menu + Search"
- One question: "Which one, or alternative?"

### Page proposal turn (T10, T15, ...)
- Use the consolidated table format from `page-proposal-format.md`.
- One question: "Approve, or adjust which sections?"
- Accept bulk approval ("approved") or targeted edits ("section 3 use option B, section 5 swap accordion for tabs").

### Asset mapping turn (T12)
- List every asset filename used in this page and the section it goes to.
- One question: "Confirm mapping?"
- If a referenced asset is missing from `_input/assets/`, list it under "MISSING" and ask the user to provide it before continuing.

### Build delivery turn (T14)
- Deliver: URL, two screenshot paths, brief summary, any diffs detected, and "next page" pointer.

## What never to do in conversation

- Never propose generic widget lists ("you could use Heading, Button, Image..."). Always concrete combinations for that section.
- Never ask permission for trivial steps already approved (like rebuilding a section after the user said "use option B").
- Never bundle two unrelated questions in a single turn.
- Never proceed without explicit approval after presenting a proposal.
- Never re-ask globals on later pages unless the user reopens them.

## Targeted adjustments grammar

When the user requests targeted changes, parse common forms:

- "section N use option B"
- "swap X for Y in section N"
- "in section 3 add a button that says ..."
- "remove section N"
- "add a section between N and N+1 with ..."

If the request is ambiguous, ask one focused clarifying question. Do not guess.

## Bulk approval phrases

Treat these as full approval to proceed:

- "approved", "ok", "go", "build it", "yes", "proceed"
- the same in Spanish: "aprobado", "ok", "adelante", "constrúyelo", "sí", "procede"

If the message contains both approval and adjustments ("ok but in section 3..."), apply adjustments and proceed.
